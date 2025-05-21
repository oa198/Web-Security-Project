<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SectionRequest extends FormRequest
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
            'course_id' => 'required|exists:courses,id',
            'section_number' => 'required|string|max:10',
            'instructor_id' => 'required|exists:users,id',
            'room' => 'nullable|string|max:50',
            'building' => 'nullable|string|max:100',
            'days' => 'required|string|max:20',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'capacity' => 'required|integer|min:1',
            'waitlist_capacity' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'registration_start_date' => 'required|date',
            'registration_end_date' => 'required|date|after:registration_start_date',
            'semester' => 'required|string|max:20',
            'academic_year' => 'required|string|max:20',
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
            'course_id.required' => 'A course must be selected.',
            'course_id.exists' => 'The selected course does not exist.',
            'section_number.required' => 'A section number is required.',
            'instructor_id.required' => 'An instructor must be assigned to the section.',
            'instructor_id.exists' => 'The selected instructor does not exist.',
            'days.required' => 'The days of the week for the section are required.',
            'start_time.required' => 'A start time is required.',
            'start_time.date_format' => 'The start time must be in the format HH:MM.',
            'end_time.required' => 'An end time is required.',
            'end_time.date_format' => 'The end time must be in the format HH:MM.',
            'end_time.after' => 'The end time must be after the start time.',
            'capacity.required' => 'Section capacity is required.',
            'capacity.integer' => 'Section capacity must be a number.',
            'capacity.min' => 'Section capacity must be at least 1.',
            'registration_start_date.required' => 'Registration start date is required.',
            'registration_end_date.required' => 'Registration end date is required.',
            'registration_end_date.after' => 'Registration end date must be after the start date.',
            'semester.required' => 'Semester is required.',
            'academic_year.required' => 'Academic year is required.',
        ];
    }
}
