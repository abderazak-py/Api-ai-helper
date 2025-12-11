<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GeneratePromptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'image' => [
                'required',
                'file',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
                'min:1',
                'dimensions:min_width=100,min_height=100,max_width=3000,max_height=3000',
            ], // max 5MB
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => 'An image file is required.',
            'image.file' => 'The uploaded file must be a valid file.',
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpg, jpeg, png, webp.',
            'image.max' => 'The image size must not exceed 5MB.',
            'image.min' => 'The image size must be at least 1 Kbytes.',
            'image.dimensions' => 'The image dimensions must be between 100x100 and 3000x3000 pixels.',
        ];
    }
}
