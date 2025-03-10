<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public function classes()
    {
        return $this->belongsToMany(Classes::class, 'classes_student'); // Explicitly define pivot table name
    }


    // Set the fillable fields
    protected $fillable = ['name', 'gender', 'dob'];
}
