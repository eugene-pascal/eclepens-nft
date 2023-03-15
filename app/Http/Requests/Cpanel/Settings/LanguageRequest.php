<?php

namespace App\Http\Requests\Cpanel\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class LanguageRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $сode = Rule::unique('languages');
        if (!empty($this->lang)) {
            $сode->ignore($this->lang->id);
        }

        return [
            'lang_name' => 'required|max:64',
            'lang_code' => [
                'required',
                'alpha_dash',
                'max:5',
                $сode
            ]
        ];
    }
}
