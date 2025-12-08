<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255|min:3',
            'body' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required',
            'title.string' => 'Title must be a string',
            'title.max' => 'Title must be less than 255 characters',
            'title.min' => 'Title must be more than 3 characters',
            'body.required' => 'Body is required',
            'body.string' => 'Body must be a string',
        ];
    }
}
