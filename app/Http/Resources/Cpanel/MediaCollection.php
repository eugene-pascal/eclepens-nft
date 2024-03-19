<?php

namespace App\Http\Resources\Cpanel;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\Member $this */
        $response = [
            'id' => $this->id ?? null,
            'mime_type' => $this->mime_type,
            'original_url' => $this->original_url,
            'thumb_url' => $this->getUrl('thumb'),
            'name' => $this->name,
            'size' => $this->size,
            'collection_name' => $this->collection_name,
            'model' => [
                'id' => $this->model_id,
                'type' => $this->model_type,
            ]
        ];

        return $response;
    }
}
