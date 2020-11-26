<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

    public function lecturer(){
        return $this->belongsTo('App\Models\Lecturer');
    }

    public function student_location(){
        return $this->hasMany('App\Models\StudentLocation');
    }

    public function krs(){
        return $this->hasMany('App\Models\Krs');
    }

    public function classroom(){
        return $this->belongsToMany('App\Models\Classroom', 'krs', 'classroom_id', 'student_id');
    }
}
