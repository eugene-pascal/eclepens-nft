<?php

namespace App\Http\Requests\Cpanel\Partners;

class OnlyPartnerAllowed extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (\Auth::user()->isPartner()) {
            return true;
        }
        return false;
    }
}
