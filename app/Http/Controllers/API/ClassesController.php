<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classes;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Support\Facades\Validator;

class ClassesController extends Controller
{
    // Fetch all classes
    public function index()
    {
        $classes = Classes::with('teacher', 'students')->get(); // Load teacher and students with the class
        return response()->json([
            'status' => 'success',
            'message' => 'Classes fetched successfully',
            'data' => $classes
        ]);
    }

    // Create a new class
    // In your ClassesController
public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'level' => 'required|string|max:255',
        'study_time' => 'required|string|max:255',
        'teacher_id' => 'required|exists:teachers,id',
        'student_ids' => 'nullable|array',
        'student_ids.*' => 'exists:students,id',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Validation failed',
            'data' => $validator->errors()
        ], 400);
    }

    // Create the class
    $class = Classes::create([
        'level' => $request->level,
        'study_time' => $request->study_time,
        'teacher_id' => $request->teacher_id,
    ]);

    // Attach students to the class
    if ($request->has('student_ids')) {
        $class->students()->attach($request->student_ids);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Class created successfully',
        'data' => $class
    ]);
}


    // Show a class by ID
    public function show($id)
    {
        $class = Classes::with('teacher', 'students')->find($id);

        if (!$class) {
            return response()->json([
                'status' => 'error',
                'message' => 'Class not found'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Class found',
            'data' => $class
        ]);
    }

    // Update a class's details
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'level' => 'required|string|max:255',
            'study_time' => 'required|string|max:255',
            'teacher_id' => 'required|exists:teachers,id', // Ensure teacher exists
            'student_ids' => 'nullable|array',  // An array of student IDs
            'student_ids.*' => 'exists:students,id',  // Ensure each student ID is valid
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'data' => $validator->errors()
            ], 400);
        }

        $class = Classes::find($id);

        if (!$class) {
            return response()->json([
                'status' => 'error',
                'message' => 'Class not found'
            ], 404);
        }

        // Update class details
        $class->update([
            'level' => $request->level,
            'study_time' => $request->study_time,
            'teacher_id' => $request->teacher_id
        ]);

        // Update students if provided
        if ($request->has('student_ids')) {
            $class->students()->sync($request->student_ids);  // Sync the students
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Class updated successfully',
            'data' => $class
        ]);
    }

    // Delete a class
    public function destroy($id)
    {
        $class = Classes::find($id);

        if (!$class) {
            return response()->json([
                'status' => 'error',
                'message' => 'Class not found'
            ], 404);
        }

        // Delete the class
        $class->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Class deleted successfully',
            'data' => null
        ]);
    }
}
