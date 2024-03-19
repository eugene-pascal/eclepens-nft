<?php

namespace App\Http\Requests\Cpanel\Nft;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EditRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $slug = Rule::unique('nfts');
        if (!empty($this->nft)) {
            $slug->ignore($this->nft->id);
        }

        return [
            'prior' => [
                'required',
                'numeric',
                'alpha_dash',
                'max:999',
                $slug
            ],
            'name' => 'required|max:255',
            'standard' => 'required|max:32',
            'descr' => 'required',
            'max_nft' => 'required|integer|min:10|max:1000',
            'slug' => [
                'required',
                'alpha_dash',
                'max:256',
                $slug
            ]
        ];
    }
}
