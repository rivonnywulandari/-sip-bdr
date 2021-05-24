<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAttendance extends Model
{
    use HasFactory;
    protected $fillable = [ 
        'presence_status',
        'needs_review'
    ];

    public function meeting(){
        return $this->belongsTo('App\Models\Meeting');
    }

    public function krs(){
        return $this->belongsTo('App\Models\Krs');
    }

    public function student_location(){
        return $this->belongsTo('App\Models\StudentLocation');
    }
}
