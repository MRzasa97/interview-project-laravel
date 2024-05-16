<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    public static array $rules = [
        'employee.create' => [
            'first_name' => 'required|string|max:255|not_regex:/^\d+$/',
            'surname' => 'required|string|max:255|not_regex:/^\d+$/'
        ]
    ];
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
        return self::$rules[$this->route()->getName()];
    }

    public function messages(): array
    {
        return [
            'first_name.not_regex' => 'first name can not be numbers!',
            'surname.not_regex' => 'surname can not be numbers!'
        ];
    }
}
