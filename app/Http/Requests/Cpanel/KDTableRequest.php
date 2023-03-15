<?php

namespace App\Http\Requests\Cpanel;

use Illuminate\Foundation\Http\FormRequest;

class KDTableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!\Auth::guest()) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    protected function prepareForValidation() {
        $data = [
            'page' => $this->pagination['page']
        ];
        app('request')->merge($data);
        $this->merge($data);
    }
}
