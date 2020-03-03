<?php
/**
 * @author Lam Kai Loon <lkloon123@hotmail.com>
 */

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;


class BaseResource extends JsonResource
{
    protected function dateTimeData()
    {
        $res = [
            'created_at' => $this->created_at !== null ? $this->created_at->format('Y-m-d H:i:s') : null,
            'updated_at' => $this->updated_at !== null ? $this->updated_at->format('Y-m-d H:i:s') : null,
            'deleted_at' => $this->deleted_at !== null ? $this->deleted_at->format('Y-m-d H:i:s') : null,
        ];

        if ($this->deleted_at === null)
            return \Arr::except($res, 'deleted_at');

        return $res;
    }
}
