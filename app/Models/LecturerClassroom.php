<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LecturerClassroom extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'lecturer_id', 
        'classroom_id'
    ];

    public function lecturer(){
        return $this->belongsTo('App\Models\Lecturer');
    }

    public function classroom(){
        return $this->belongsTo('App\Models\Classroom');
    }

    public function meeting(){
        return $this->hasMany('App\Models\Meeting');
    }
}
