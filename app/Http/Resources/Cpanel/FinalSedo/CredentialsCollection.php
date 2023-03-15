<?php

namespace App\Http\Resources\Cpanel\FinalSedo;

use Illuminate\Http\Resources\Json\JsonResource;

class CredentialsCollection extends JsonResource
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
            'username' => $this->username,
            'password' => $this->password,
            'partnerid' => $this->partnerid,
            'signkey' => $this->signkey,
            'is_active' => $this->is_active
        ];
        return $response;
    }
}
