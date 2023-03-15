<?php

namespace App\Http\Requests\Cpanel\FinalSedo;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CredentialRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required|max:16',
            'password' => 'required|max:16',
            'partnerid' => 'required|max:12',
            'signkey' => 'required|max:32'
        ];
    }


}
