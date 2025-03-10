<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeacherRequest;  // Custom Form Request for validation
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    // Fetch all teachers
    public function index(Request $request)
    {
        $teachers = Teacher::all();
        return response()->json([
            "status" => "success",
            "message" => "Teachers fetched successfully",
            "data" => $teachers
        ]);
    }

    // Store a new teacher
    public function store(TeacherRequest $request)
    {
        $teacher = Teacher::create($request->validated());

        return response()->json([
            "status" => "success",
            "message" => "Teacher created successfully",
            "data" => $teacher
        ]);
    }

    // Show a teacher by ID
    public function show($id)
    {
        $teacher = Teacher::find($id);

        if (!$teacher) {
            return response()->json([
                "status" => "error",
                "message" => "Teacher not found",
            ], 404);
        }

        return response()->json([
            "status" => "success",
            "message" => "Teacher found",
            "data" => $teacher
        ]);
    }

    // Update a teacher's details
    public function update(TeacherRequest $request, Teacher $teacher)
    {
        // Validate incoming request data using custom request validation
        $teacher->update($request->validated());

        return response()->json([
            "status" => "success",
            "message" => "Teacher updated successfully",
            "data" => $teacher
        ]);
    }

    // Delete a teacher
    public function destroy(Teacher $teacher)
    {
        if (!$teacher) {
            return response()->json([
                "status" => "error",
                "message" => "Teacher not found",
            ], 404);
        }

        $teacher->delete();

        return response()->json([
            "status" => "success",
            "message" => "Teacher deleted successfully",
            "data" => null
        ]);
    }
}
