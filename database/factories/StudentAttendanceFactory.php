<?php

namespace Database\Factories;

use App\Models\StudentAttendance;
use App\Models\Krs;
use App\Models\StudentLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentAttendanceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StudentAttendance::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $krs_ids = Krs::select('id')->get();
        $student_location_ids = StudentLocation::join('students', 'students.id', 'student_locations.student_id')
                        ->join('krs', 'students.id', 'krs.student_id')
                        ->select('student_locations.id')
                        ->where('krs.classroom_id', '=', 3)
                        ->get();

        return [
            'krs_id' => $this->faker->unique()->numberBetween(108, 120),
            'meeting_id' => 85,
            'student_location_id' => $this->faker->randomElement($student_location_ids),
            'presence_status' => $this->faker->randomElement($array = array ('Hadir','Absen','Izin')),
        ];
    }
}
