<?php

namespace Database\Seeders;

use App\Models\StudentAttendance;
use App\Models\StudentLocation;
use App\Models\Meeting;
use App\Models\Krs;
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
        //StudentAttendance::truncate();
        
        $student_locations = StudentLocation::where('student_id', '<=', '20')->get();
        $krs_krs = Krs::groupBy('student_id')->get();
        $meetings = Meeting::groupBy('lecturer_classroom_id')->get();

        foreach($meetings as $meeting){
            foreach($student_locations as $student_location){
                foreach($krs_krs as $krs){
                    StudentAttendance::factory(1)->create([
                        'student_location_id' => $student_location->id,
                        'meeting_id' => $meeting->id,
                        'krs_id' => $krs->id
                        ]);
                }
            }
        }
    }
}