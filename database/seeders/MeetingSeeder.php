<?php

namespace Database\Seeders;

use App\Models\Meeting;
use App\Models\LecturerClassroom;
use Illuminate\Database\Seeder;

class MeetingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Meeting::truncate();
        
        $lecturer_classrooms = LecturerClassroom::all();

        foreach($lecturer_classrooms as $lecturer_classroom){
            Meeting::factory(3)->create(['lecturer_classroom_id' => $lecturer_classroom->id]);
        }
    }
}
