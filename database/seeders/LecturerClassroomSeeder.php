<?php

namespace Database\Seeders;

use App\Models\Lecturer;
use App\Models\LecturerClassroom;
use Illuminate\Database\Seeder;

class LecturerClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //LecturerClassroom::truncate();
        
        $lecturers = Lecturer::where('id', '>', '10')->get();

        foreach($lecturers as $lecturer){
            LecturerClassroom::factory(3)->create(['lecturer_id' => $lecturer->id]);
        }
    }
}
