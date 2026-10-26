<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $teacher = $this->route('teacher');

        return [
            'employee_number' => ['sometimes', 'nullable', 'string', 'max:50', Rule::unique('teachers', 'employee_number')->ignore($teacher)],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'email' => ['sometimes', 'nullable', 'email', 'max:255', Rule::unique('teachers', 'email')->ignore($teacher)],
            'phone' => ['sometimes', 'nullable', 'string', 'max:30'],
            'specialization' => ['sometimes', 'nullable', 'string', 'max:255'],
        ];
    }
}
