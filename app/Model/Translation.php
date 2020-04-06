<?php

namespace App\Model;

/**
 * App\Model\Translation
 *
 * @property int $id
 * @property string $group
 * @property string $key
 * @property string|null $text
 * @property int $language_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 * @property-read \App\Model\Language $language
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Translation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Translation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Translation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Translation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Translation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Translation whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Translation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Translation whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Translation whereLanguageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Translation whereText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Translation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Translation extends BaseModel
{
    protected $touches = ['language'];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
