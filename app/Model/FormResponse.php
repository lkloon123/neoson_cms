<?php

namespace App\Model;

use Illuminate\Support\Str;

/**
 * App\Model\FormResponse
 *
 * @property int $id
 * @property int $form_id
 * @property array $meta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Model\Form $form
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormResponse newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormResponse newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormResponse query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormResponse whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormResponse whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormResponse whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormResponse whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormResponse whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormResponse whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read int|null $audits_count
 */
class FormResponse extends BaseModel
{
    protected $casts = [
        'meta' => 'array'
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function buildColumns()
    {
        $columns = [];
        foreach ($this->meta as $key => $value) {
            $columns[] = [
                'label' => Str::title(str_replace('_', ' ', $key)),
                'field' => $key,
            ];
        }

        $columns[] = [
            'label' => 'Submitted On',
            'field' => 'created_at',
        ];

        return ['columns' => $columns];
    }
}
