<?php

namespace App\Http\Requests;

use App\Models\Student;
use Illuminate\Foundation\Http\FormRequest;

class StoreStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'student_id'      => ['required', 'string', 'max:20', 'unique:students,student_id'],
            'first_name'      => ['required', 'string', 'max:100'],
            'middle_name'     => ['nullable', 'string', 'max:100'],
            'last_name'       => ['required', 'string', 'max:100'],
            'email'           => ['required', 'email', 'max:255', 'unique:students,email'],
            'mobile_number'   => ['required', 'string', 'max:20', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'gender'          => ['required', 'in:Male,Female,Other'],
            'date_of_birth'   => ['required', 'date', 'before:today', 'after:1900-01-01'],
            'program'         => ['required', 'string', 'max:100'],
            'year_level'      => ['required', 'in:' . implode(',', Student::YEAR_LEVELS)],
            'address'         => ['required', 'string', 'max:500'],
            'profile_picture' => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'student_id.unique'         => 'This Student ID is already registered.',
            'email.unique'              => 'This email address is already registered.',
            'mobile_number.regex'       => 'Please enter a valid mobile number.',
            'date_of_birth.before'      => 'Date of birth must be before today.',
            'profile_picture.required'  => 'A profile picture is required.',
            'profile_picture.image'     => 'The profile picture must be a valid image.',
            'profile_picture.mimes'     => 'Only JPG, JPEG, and PNG files are allowed.',
            'profile_picture.max'       => 'The profile picture must not exceed 2MB.',
        ];
    }
}
