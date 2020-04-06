<?php

namespace App\Model;

/**
 * App\Model\Language
 *
 * @property int $id
 * @property string $code
 * @property string $title
 * @property string $country_iso
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\Translation[] $translations
 * @property-read int|null $translations_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Language whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Language whereCountryIso($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Language whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Language whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Language whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Language whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Language extends BaseModel
{
    public function translations()
    {
        return $this->hasMany(Translation::class);
    }

    public function getTranslationsGroups()
    {
        return $this->translations
            ->mapToGroups(function (Translation $translation) {
                return [
                    $translation->group => [
                        'id' => $translation->id,
                        'key' => $translation->key,
                        'text' => $translation->text,
                        'created_at' => $translation->created_at,
                        'updated_at' => $translation->updated_at,
                    ]
                ];
            });
    }

    public function getFormattedTranslationsGroup() {
        $formatted = [];
        $grouped = $this->getTranslationsGroups();

        foreach ($grouped as $group => $translations) {
            if (!isset($formatted[$group])) {
                $formatted[$group] = [];
            }
            foreach ($translations as $translation) {
                $formatted[$group] = array_merge(
                    $formatted[$group],
                    [$translation['key'] => $translation['text']]
                );
            }
        }

        return $formatted;
    }
}
