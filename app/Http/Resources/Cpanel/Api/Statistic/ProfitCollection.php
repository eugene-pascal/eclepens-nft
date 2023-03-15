<?php

namespace App\Http\Resources\Cpanel\Api\Statistic;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfitCollection extends JsonResource
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
            'id' => $this->id,
            'day' => $this->day,
            'strategy' => $this->strategy,
            'profit' => $this->profit
        ];

        return $response;
    }
}
