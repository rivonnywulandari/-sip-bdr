<?php

namespace Database\Factories;

use App\Models\StudentAttendance;
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
        return [
            'krs_id' => 1,
            'meeting_id' => 1,
            'student_location_id' => 1,
            'presence_status' => $this->faker->randomElement($array = array ('Hadir','Absen','Izin')),
        ];
    }
}
