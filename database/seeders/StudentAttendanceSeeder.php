<?php

namespace Database\Seeders;

use App\Models\StudentAttendance;
use App\Models\StudentLocation;
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
        $student_locations = StudentLocation::all();

        foreach($student_locations as $student_location){
            StudentAttendance::factory(6)->create(['student_location_id' => $student_location->id]);
        }
    }
}