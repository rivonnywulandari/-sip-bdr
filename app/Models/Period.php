<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [ 
        'year', 
        'semester'
    ];
    
    public function classroom(){
        return $this->hasMany('App\Models\Classroom');
    }

    public function getPeriodAttribute(){
        return $this->semester . ' ' . $this->year;
    }
}
