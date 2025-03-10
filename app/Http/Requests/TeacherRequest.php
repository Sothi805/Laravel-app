<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherRequest extends FormRequest
{
    public function authorize()
    {
        return true;  // Allow all users to perform these actions
    }

    public function rules()
    {
        return [
            "name" => "required",
            "gender" => "required",
            "dob" => "required|date",  // You can also add a date validation for DOB
            "phone_number" => "required|numeric",
        ];
    }
}
