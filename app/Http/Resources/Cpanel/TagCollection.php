<?php

namespace App\Http\Resources\Cpanel;

use Illuminate\Http\Resources\Json\JsonResource;

class TagCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\Tag $this */
        $response = [
            'id' => $this->id,
            'slug' => $this->slug,
            'name' => $this->name
        ];

        return $response;
    }
}
