<?php

namespace App\Http\Requests\Cpanel\Settings;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SiteRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $сode = Rule::unique('sites');
        if (!empty($this->site)) {
            $сode->ignore($this->site->id);
        }

        return [
            'name' => 'required|max:64',
            'url' => 'string|nullable|max:256|min:10',
            'code' => [
                'required',
                'alpha_dash',
                'max:5',
                'min:3',
                'regex:/^[a-z0-9]+$/i',
                $сode
            ]
        ];
    }
}
