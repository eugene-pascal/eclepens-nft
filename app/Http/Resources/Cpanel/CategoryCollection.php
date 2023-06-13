<?php

namespace App\Http\Resources\Cpanel;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        /** @var \App\Models\Category $this */
        $response = [
            'id' => $this->id,
            'prior' => $this->prior,
            'name' => $this->name,
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'prev' => Category::where('prior', '<', $this->prior)->orderBy('prior','desc')->first(),
            'next' => Category::where('prior', '>', $this->prior)->orderBy('prior','asc')->first(),
        ];
        return $response;
    }
}
