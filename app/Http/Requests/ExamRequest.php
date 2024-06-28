<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExamRequest extends FormRequest
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
            'datetime_start' => ['required', 'date', 'after:now'],
            'datetime_end' => ['required', 'date', 'after:datetime_start'],
            'time' => 'required|numeric|min:5',
            'questions' => 'required|array|min:2'
        ];
    }
}
