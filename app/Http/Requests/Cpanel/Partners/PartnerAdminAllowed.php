<?php

namespace App\Http\Requests\Cpanel\Partners;

class PartnerAdminAllowed extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (\Auth::user()->isPartner() || \Auth::user()->isAdmin()) {
            return true;
        }
        return false;
    }
}
