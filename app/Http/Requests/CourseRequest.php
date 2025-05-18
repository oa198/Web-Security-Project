<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization is handled in the controller
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'code' => [
                'required',
                'string',
                'max:10',
                Rule::unique('courses')->ignore($this->route('id')),
            ],
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'credits' => 'required|integer|min:1|max:6',
            'department_id' => 'required|exists:departments,id',
            'professor_id' => 'nullable|exists:users,id',
            'prerequisite_ids' => 'nullable|array',
            'prerequisite_ids.*' => 'exists:courses,id',
            'is_active' => 'nullable|boolean',
            'level' => 'required|string|in:freshman,sophomore,junior,senior,graduate',
            'max_capacity' => 'nullable|integer|min:1',
            'current_enrollment' => 'nullable|integer|min:0',
        ];

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'code.required' => 'The course code is required.',
            'code.unique' => 'The course code already exists.',
            'title.required' => 'The course title is required.',
            'credits.required' => 'The number of credits is required.',
            'department_id.required' => 'The department is required.',
            'department_id.exists' => 'The selected department does not exist.',
            'professor_id.exists' => 'The selected professor does not exist.',
            'prerequisite_ids.*.exists' => 'One of the selected prerequisite courses does not exist.',
            'level.required' => 'The course level is required.',
            'level.in' => 'The course level must be one of: freshman, sophomore, junior, senior, graduate.',
        ];
    }
}
