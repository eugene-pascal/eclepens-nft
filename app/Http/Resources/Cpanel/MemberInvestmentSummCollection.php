<?php

namespace App\Http\Resources\Cpanel;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberInvestmentSummCollection extends JsonResource
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
            'invested_usd' => $this->invested_usd,
            'returned_btc' => $this->returned_btc,
            'daily_profit_usd' => $this->daily_profit_usd,
            'total_profit_usd' => $this->total_profit_usd,
            'withdrawn_profit_usd' => $this->withdrawn_profit_usd,
            'current_profit_usd' => $this->current_profit_usd,
            'invested_date' => $this->invested_date
        ];

        return $response;
    }
}
