<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;  // Import the Student model
use App\Models\Classes;  // Import the Classes model if you are working with relationships
use App\Http\Requests\StudentRequest;  // Custom request validation (if you have it)

class StudentController extends Controller
{
    // Fetch all students
    public function index(Request $request)
    {
        $students = Student::all(); // Fetch all students
        return response()->json([
            "status" => "success",
            "message" => "Students fetched successfully",
            "data" => $students
        ]);
    }

    // Store a new student
    public function store(StudentRequest $request)
    {
        // Create a new student with validated data
        $student = Student::create($request->validated());

        return response()->json([
            "status" => "success",
            "message" => "Student created successfully",
            "data" => $student
        ]);
    }

    // Show a student by ID
    public function show($id)
    {
        $student = Student::find($id);  // Find student by ID

        if (!$student) {
            return response()->json([
                "status" => "error",
                "message" => "Student not found",
            ], 404);
        }

        return response()->json([
            "status" => "success",
            "message" => "Student found",
            "data" => $student
        ]);
    }

    // Update a student's details
    public function update(StudentRequest $request, Student $student)
    {
        // Validate and update the student's details
        $student->update($request->validated());

        return response()->json([
            "status" => "success",
            "message" => "Student updated successfully",
            "data" => $student
        ]);
    }

    // Delete a student
    public function destroy(Student $student)
    {
        if (!$student) {
            return response()->json([
                "status" => "error",
                "message" => "Student not found",
            ], 404);
        }

        $student->delete();

        return response()->json([
            "status" => "success",
            "message" => "Student deleted successfully",
            "data" => null
        ]);
    }
}
