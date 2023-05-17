<?php

namespace App\Http\Resources\Cpanel;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleCollection extends JsonResource
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
            'slug' => $this->slug,
            'code_lang2' => $this->code_lang2,
            'code_unique' => $this->code_unique,
            'code_name' => $this->code_name,
            'title' => $this->title,
            'meta_title' => $this->meta_title,
            'display' => $this->display,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'tags' => TagCollection::collection($this->tags)
        ];

        return $response;
    }
}
