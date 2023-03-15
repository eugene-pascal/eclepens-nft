<?php

namespace App\Http\Resources\Cpanel;

use Illuminate\Http\Resources\Json\JsonResource;

class MemberCollection extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'fullname' => $this->getFullName(),
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'description' => $this->description,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];

        if ('member' === $this->type_account && $this->partnerConnection()->count()) {
            $response['partner_conn'] = $this->partnerConnection()->first();
        }
        if ('partner' === $this->type_account && $this->memberConnection()->count()) {
            $response['members_not_approved_cc'] = $this->memberConnection()->where('approved', false)->count();
        }

        return $response;
    }
}
