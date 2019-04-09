<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 4/5/2019
 * Time: 10:53 AM.
 */

namespace App\Model;


use Illuminate\Support\Collection;

class Setting
{
    protected static $availableGroups = [
        'general' => [
            'site-title' => 'app.name',
            'site-description' => 'app.description',
            'admin-email' => 'app.admin.email'
        ]
    ];
    protected $selectedGroup;
    protected $loadedSettings;

    private function __construct($selectedGroup)
    {
        if (!($selectedGroup instanceof Collection)) {
            $selectedGroup = collect($selectedGroup);
        }
        $this->selectedGroup = $selectedGroup;
        $this->loadedSettings = collect([]);
    }

    public static function find($group)
    {
        $groupCollection = collect(self::$availableGroups);

        if ($groupCollection->has($group)) {
            $ins = new self($groupCollection->get($group));
            $ins->load();
            return $ins;
        }

        return null;
    }

    protected function load()
    {
        $this->selectedGroup->each(function ($settingKey, $publicKey) {
            $this->loadedSettings[$publicKey] = $this->getFromPersistSetting($settingKey);
        });
    }

    protected function getFromConfig($key)
    {
        return config($key);
    }

    protected function getFromPersistSetting($key)
    {
        return setting($key, $this->getFromConfig($key));
    }

    public function get($key = null)
    {
        if ($key === null) {
            return $this->loadedSettings;
        }
        return $this->loadedSettings->get($key);
    }

    public function set($key, $value = null)
    {
        if (\is_array($key)) {
            foreach ($key as $item => $itemValue) {
                if ($this->selectedGroup->has($item)) {
                    setting()->set($this->selectedGroup->get($item), $itemValue);
                }
            }
        } else {
            if ($this->selectedGroup->has($key)) {
                setting()->set($this->selectedGroup->get($key), $value);
            }
        }

        setting()->save();
    }
}
