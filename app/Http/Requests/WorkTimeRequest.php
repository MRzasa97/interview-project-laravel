<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkTimeRequest extends FormRequest
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
        $rules = [
            'worktime.register' => [
                'employee_id' => 'required|exists:employees,id',
                'start_time' => 'required|regex:/^\d{4}\-\d{2}\-\d{2} \d{2}:\d{2}$/',
                'end_time' => 'required|regex:/^\d{4}\-\d{2}\-\d{2} \d{2}:\d{2}$/|after:start_time'
            ]
        ];

        return $rules[$this->route()->getName()];
    }

    public function messages(): array
    {
        return [
            'start_time.regex' => 'Start time must be in the format: yyyy-mm-dd hh:mm',
            'end_time.regex' => 'End time must be in the format: yyyy-mm-dd hh:mm'
        ];
    }
}
