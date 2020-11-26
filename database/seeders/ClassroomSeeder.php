<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Period;
use App\Models\Classroom;
use Illuminate\Database\Seeder;

class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Classroom::truncate();
        //Course::truncate();
        
        $courses = Course::factory(35)->create();
        Period::factory(6)->create();

        foreach($courses as $course){
            Classroom::factory(1)->create(['course_id' => $course->id]);
        }
    }
}
