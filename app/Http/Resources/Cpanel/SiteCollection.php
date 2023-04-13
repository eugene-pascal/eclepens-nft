<?php

namespace App\Http\Resources\Cpanel;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\Site $this */
        $response = [
            'id' => $this->id,
            'name' => $this->name,
            'url' => $this->url,
            'code' => $this->code,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];

        return $response;
    }
}
