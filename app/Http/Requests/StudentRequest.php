<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Or add logic to restrict access
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female',
            'dob' => 'required',
            'class_ids' => 'nullable|array',  // To handle attaching to classes
            'class_ids.*' => 'exists:classes,id',  // Ensure class IDs are valid
        ];
    }
}
