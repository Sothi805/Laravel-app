<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    public function classes()
    {
        return $this->hasMany(Classes::class);
    }
    protected $fillable = ["name", "gender", "dob", "phone_number"];
}
