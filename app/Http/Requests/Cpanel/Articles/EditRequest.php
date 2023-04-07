<?php

namespace App\Http\Requests\Cpanel\Articles;

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
        $slug = Rule::unique('articles');
        if (!empty($this->article)) {
            $slug->ignore($this->article->id);
        }

        return [
            'code_lang2' => 'required',
            'code_name' => 'required',
            'title' => 'required',
            'text' => 'required',
            'slug' => [
                'required',
                'alpha_dash',
                'max:256',
                $slug
            ],
            'code_unique' => [
                'required',
                'alpha_dash',
                'max:256',
                $slug
            ],
        ];
    }

    /**
     * Prepare before validate
     */
    protected function prepareForValidation() {
        $data = [
            'slug' => !empty($this->slug) ? $this->slug : Str::slug($this->header),
            'title' => $this->title ?? $this->header,
            'keywords' => $this->keywords ?? '',
            'description' => $this->description ?? $this->header,
        ];
        app('request')->merge($data);
        $this->merge($data);
    }
}
