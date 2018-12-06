<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->method() == 'PUT') {
            return [
                'name' => 'required|string',
                'description' => 'required|string',
                'logo' => 'image',
                'users' => 'array'
            ];
        }
        return [
            'name' => 'required|string',
            'description' => 'required|string',
            'logo' => 'required|image',
            'users' => 'array'
        ];
    }
}
