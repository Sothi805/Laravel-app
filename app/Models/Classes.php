<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    // Define the relationship with the teacher
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);  // 'Teacher' is the related model
    }

    // Define the relationship with students
    public function students()
    {
        return $this->belongsToMany(Student::class, 'class_student', 'class_id', 'student_id');
    }
    // Set the fillable fields
    protected $fillable = ['level', 'study_time', 'teacher_id'];
}
