<?php

namespace App\Model;

/**
 * App\Model\FormComponent
 *
 * @property int $id
 * @property string $html_component
 * @property array $default_meta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read int|null $audits_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormComponent newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormComponent newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormComponent query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormComponent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormComponent whereDefaultMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormComponent whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormComponent whereHtmlComponent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormComponent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormComponent whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FormComponent extends BaseModel
{
    protected $casts = [
        'default_meta' => 'array',
    ];

    protected $fillable = [
        'html_component', 'default_meta'
    ];
}
