<?php

namespace Database\Seeders;

use App\Models\ClassroomSchedule;
use App\Models\Classroom;
use Illuminate\Database\Seeder;

class ClassroomScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classrooms = Classroom::all();

        foreach($classrooms as $classroom){
            ClassroomSchedule::factory(1)->create(['classroom_id' => $classroom->id]);
        }
    }
}
