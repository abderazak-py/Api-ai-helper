<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AnswerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'question' => ['required', 'string', 'max:255', 'min:3', 'regex:/^[^<>%$#&*]+$/'],
        ];
    }

    public function messages()
    {
        return [
            'question.required' => 'Question is required',
            'question.string' => 'Question must be a string',
            'question.max' => 'Question must be less than 255 characters',
            'question.min' => 'Question must be more than 3 characters',
            'question.regex' => 'Question must not contain special characters',
        ];
    }
}
