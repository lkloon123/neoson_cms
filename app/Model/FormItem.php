<?php

namespace App\Model;

use Illuminate\Support\Str;

/**
 * App\Model\FormItem
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \App\Model\Form $form
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormItem query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $form_id
 * @property int $display_order
 * @property string $meta_id
 * @property array $meta
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormItem whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormItem whereDisplayOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormItem whereFormId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormItem whereMeta($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormItem whereMetaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\FormItem whereUpdatedAt($value)
 * @property-read mixed $is_required
 * @property-read mixed $label
 * @property-read mixed $type
 * @property-read mixed $name
 */
class FormItem extends BaseModel
{
    protected $casts = [
        'meta' => 'array'
    ];

    protected $touches = ['form'];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function getTypeAttribute()
    {
        return $this->meta['type'];
    }

    public function getIsRequiredAttribute()
    {
        if (isset($this->meta['isRequired']) && $this->meta['isRequired']) {
            return $this->meta['isRequired'];
        }

        return null;
    }

    public function getLabelAttribute()
    {
        if ($this->is_required) {
            return $this->meta['label'] . '&nbsp;<span style="color: #ff0000;">*</span>';
        }

        return $this->meta['label'];
    }

    public function getNameAttribute()
    {
        return Str::snake($this->meta['label']);
    }
}
