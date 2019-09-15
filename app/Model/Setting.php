<?php
/**
 * Created by PhpStorm.
 * User: Neoson Lam
 * Date: 4/5/2019
 * Time: 10:53 AM.
 */

namespace App\Model;

use Illuminate\Contracts\Config\Repository as ConfigContract;
use Illuminate\Support\Collection;

class Setting implements ConfigContract
{
    protected $selectedGroup;
    protected $loadedSettings;
    protected $loadedSettingForms;

    private function __construct($selectedGroup)
    {
        if (!($selectedGroup instanceof Collection)) {
            $selectedGroup = collect($selectedGroup);
        }
        $this->selectedGroup = $selectedGroup;
        $this->loadedSettings = collect();
        $this->loadedSettingForms = collect();
    }

    public static function find($group = 'default')
    {
        /** @var Collection $groupCollection */
        $groupCollection = collect(self::availableGroup())->recursive();

        if (!$groupCollection->has($group)) {
            return null;
        }

        $ins = new self($groupCollection->get($group));
        $ins->load();

        return $ins;
    }

    protected function load()
    {
        $this->selectedGroup->each(function (Collection $settingData) {
            $this->loadedSettings->put(
                $settingData->get('public-key'),
                config($settingData->get('private-key'))
            );
            $this->loadedSettingForms->put(
                $settingData->get('public-key'),
                $settingData->get('form')
            );
        });
    }

    protected static function availableGroup()
    {
        $defaultAvailable = [
            'default' => [],
            'general' => [
                [
                    'public-key' => 'site-title',
                    'private-key' => 'app.name',
                    'form' => [
                        'label' => 'Site Title',
                        'type' => 'text'
                    ]
                ],
                [
                    'public-key' => 'site-description',
                    'private-key' => 'app.description',
                    'form' => [
                        'label' => 'Site Description',
                        'type' => 'text'
                    ]
                ],
                [
                    'public-key' => 'admin-email',
                    'private-key' => 'app.admin.email',
                    'form' => [
                        'label' => 'Admin Email',
                        'type' => 'text',
                        'desc' => 'This email address for admin usage only'
                    ]
                ]
            ]
        ];

        $defaultAvailable = \HookManager::applyFilter('setting.group.filter', $defaultAvailable);
        return $defaultAvailable;
    }

    public function has($key)
    {
        return $this->loadedSettings->has($key);
    }

    public function get($key, $default = null)
    {
        return $this->loadedSettings->get($key, $default);
    }

    public function all()
    {
        return $this->loadedSettings;
    }

    public function set($key, $value = null)
    {
        $keyedSelectedGroup = $this->selectedGroup->keyBy('public-key');
        if (\is_array($key)) {
            foreach ($key as $item => $itemValue) {
                if ($keyedSelectedGroup->has($item)) {
                    setting()->set(
                        $keyedSelectedGroup->get($item)->get('private-key'),
                        $itemValue
                    );
                }
            }
        } else {
            if ($keyedSelectedGroup->has($key)) {
                setting()->set(
                    $keyedSelectedGroup->get($key)->get('private-key'),
                    $value
                );
            }
        }

        setting()->save();
    }

    public function prepend($key, $value)
    {
        $this->set($key, $value);
    }

    public function push($key, $value)
    {
        $this->set($key, $value);
    }

    public function getSettingForms()
    {
        return $this->loadedSettingForms;
    }
}
