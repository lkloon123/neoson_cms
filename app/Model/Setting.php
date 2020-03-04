<?php

namespace App\Model;

/**
 * App\Model\Setting
 *
 * @property int $id
 * @property string $setting_key
 * @property string $setting_value
 * @property string|null $config_key
 * @property string $type
 * @property string $group
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting whereConfigKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting whereSettingKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting whereSettingValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property array $meta
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Setting whereMeta($value)
 */
class Setting extends BaseModel
{
    protected $casts = ['setting_value' => 'string', 'meta' => 'array'];
    protected static $defaultTypes = [];

    protected function getCastType($key)
    {
        if ($key === 'setting_value' && $this->type) {
            return $this->type;
        }

        return parent::getCastType($key);
    }

    public static function saveSetting($item, $group = 'general')
    {
        $defaultType = $item['type'];

        if (isset(self::$defaultTypes[$item['setting_key']])) {
            $defaultType = self::$defaultTypes[$item['setting_key']];
        }

        return self::updateOrCreate(
            ['setting_key' => $item['setting_key'], 'group' => $group],
            ['setting_value' => $item['setting_value'], 'type' => $defaultType]
        );
    }

    public static function saveMultipleSettings(array $keyValuePairs, $group = 'general')
    {
        $result = [];

        collect($keyValuePairs)->each(function ($item) use (&$result, $group) {
            $result[] = self::saveSetting($item, $group);
        });

        return $result;
    }

    public static function getSetting($key, $default = null, $group = 'general')
    {
        $setting = self::whereSettingKey($key)
            ->whereGroup($group)
            ->first();

        if (!$setting) {
            return value($default);
        }

        return $setting->setting_value;
    }

    public static function getMultipleSettings(array $keys, $defaults = null, $group = 'general')
    {
        $result = [];

        collect($keys)->each(function ($item, $index) use ($defaults, &$result, $group) {
            $result[$item] = self::getSetting($item, $defaults[$index] ?? null, $group);
        });

        return $result;
    }

    public static function getAllSettingFromGroup($group)
    {
        return self::whereGroup($group)
            ->get();
    }

    public static function deleteSetting($key, $group = 'general')
    {
        return self::whereSettingKey($key)
            ->whereGroup($group)
            ->delete();
    }

    public static function deleteAllSettingsFromGroup($group)
    {
        return self::whereGroup($group)
            ->delete();
    }

    public static function deleteMultipleSettings(array $keys, $group = 'general')
    {
        $result = [];

        collect($keys)->each(function ($item) use (&$result, $group) {
            $result[] = self::deleteSetting($item, $group);
        });

        return $result;
    }
}
