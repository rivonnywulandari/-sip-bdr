<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [ 
        'name', 
        'course_code', 
        'sks', 
        'semester'
    ];
    
    public function classroom(){
        return $this->hasMany('App\Models\Classroom');
    }

    public function getCourseAttribute(){
        return strtoupper($this->course_code) . '/' . ucwords($this->name);
    }
}
