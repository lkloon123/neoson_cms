<?php

namespace App\Model;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * App\Model\Form
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\OwenIt\Auditing\Models\Audit[] $audits
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\FormItem[] $formItems
 * @property-read \App\Model\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Form newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Form newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Form query()
 * @mixin \Eloquent
 * @property int $id
 * @property string $name
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Form whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Form whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Form whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Form whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Form whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Model\Form whereUserId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Model\FormResponse[] $formResponses
 * @property-read int|null $audits_count
 * @property-read int|null $form_items_count
 * @property-read int|null $form_responses_count
 */
class Form extends BaseModel
{
    protected $softCascade = ['formItems'];
    public $updatedFormItemMetaId = [];
    public $dontShowInResponse = ['common_submit'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function formItems()
    {
        return $this->hasMany(FormItem::class);
    }

    public function formResponses()
    {
        return $this->hasMany(FormResponse::class);
    }

    public function insertFormItem($items)
    {
        $displayOrder = 1;
        foreach ($items as $item) {
            //insert the object
            $formItem = $this->formItems()->updateOrCreate(
                ['meta_id' => $item['id']],
                [
                    'display_order' => $displayOrder,
                    'meta_id' => $item['id'],
                    'meta' => Arr::except($item, ['id', 'validators']),
                    'validators' => $item['validators']
                ]
            );

            $this->updatedFormItemMetaId[] = $formItem->meta_id;

            ++$displayOrder;
        }
    }

    public function buildFormResponseColumn()
    {
        $formItems = $this->formItems()
            ->orderBy('display_order')
            ->get();

        $columns = [];
        foreach ($formItems as $formItem) {
            if (in_array(strtolower($formItem->formKey), $this->dontShowInResponse, true)) {
                continue;
            }

            $columns[] = [
                'label' => Str::contains($formItem->label, '.') ? $formItem->label : Str::title(str_replace(['_', '-'], ' ', $formItem->label)),
                'field' => $formItem->formKey,
            ];
        }

        $columns[] = [
            'label' => 'common.submitted_on',
            'field' => 'created_at',
        ];

        return ['columns' => $columns];
    }
}
