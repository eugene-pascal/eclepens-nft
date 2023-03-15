<?php

namespace App\Http\Resources\Cpanel;

use Illuminate\Http\Resources\Json\JsonResource;

class KDTablePaginationCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'page' => $this->currentPage(),
            'pages' => $this->lastPage(),
            'perpage' => $this->perPage(),
            'total' => $this->total(),
            'sort' => 'desc',
            'field' => 'id'
        ];
    }
}
