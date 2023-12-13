<?php

namespace App\Http\Resources\Cpanel;

use Illuminate\Http\Resources\Json\JsonResource;

class NftCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\Article $this */
        $response = [
            'id' => $this->id,
            'name' => $this->name,
            'standard' => $this->standard,
            'display' => $this->display,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'tags' => TagCollection::collection($this->tags)
        ];

        return $response;
    }
}
