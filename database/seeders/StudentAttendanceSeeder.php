<?php

namespace Database\Seeders;

use App\Models\StudentAttendance;
use App\Models\Meeting;
use Illuminate\Database\Seeder;

class StudentAttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $meetings = Meeting::all();

        // foreach($meetings as $meeting){
        //     StudentAttendance::factory(20)->create(['meeting_id' => $meeting->id]);
        // }

        StudentAttendance::factory()->count(25)->create();
    }
}