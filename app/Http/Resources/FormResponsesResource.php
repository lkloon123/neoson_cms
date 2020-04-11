<?php

namespace App\Http\Resources;

/**
 * @mixin \App\Model\FormResponse
 * */
class FormResponsesResource extends BaseResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $tmp = $this->meta;
        $tmp['id'] = $this->id;

        return $this->filterByDontShow(
            array_merge($tmp, $this->dateTimeData())
        );
    }

    protected function filterByDontShow($data)
    {
        foreach ($this->form->dontShowInResponse as $dontShow) {
            unset($data[$dontShow]);
        }

        return $data;
    }
}
