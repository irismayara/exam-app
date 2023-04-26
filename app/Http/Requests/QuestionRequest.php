<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class QuestionRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:255',
            'question' => 'required|string|min:10|max:255',
            'course' => 'required|string|min:3|max:255',
            'topic' => 'required|string|min:3|max:255',
            'tags' => 'required|string|min:2|max:255',
            'difficulty' => [
                'required', 
                Rule::in(['1', '2', '3', '4', '5']),
            ],
            'type' => [
                'required', 
                Rule::in(['1', '2', '3', '4']),
            ],
            'option.*' => 'required_if:type,2,3,4'
        ];
    }
}
