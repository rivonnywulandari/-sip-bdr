<?php

namespace Database\Factories;

use App\Models\StudentAttendance;
use App\Models\Krs;
use App\Models\Meeting;
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
        $meeting_ids = Meeting::select('id')->get();

        return [
            'krs_id' => $this->faker->randomElement($krs_ids),
            'meeting_id' => $this->faker->randomElement($meeting_ids),
            'student_location_id' => 1,
            'presence_status' => $this->faker->randomElement($array = array ('Hadir','Absen','Izin')),
        ];
    }
}
