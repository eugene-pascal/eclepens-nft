<?php

namespace App\Http\Requests\Cpanel\StaticPage;

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
        $slug = Rule::unique('static_pages');
        if (!empty($this->page)) {
            $slug->ignore($this->page->id);
        }

        return [
            'name' => 'required',
            'header' => 'required',
            'text' => 'required',
            'slug' => [
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
