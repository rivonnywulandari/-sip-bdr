<?php

namespace Database\Factories;

use App\Models\LecturerClassroom;
use App\Models\Lecturer;
use App\Models\Classroom;
use Illuminate\Database\Eloquent\Factories\Factory;

class LecturerClassroomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LecturerClassroom::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lecturer_ids = Lecturer::select('id')->get();
        $classroom_ids = Classroom::select('id')->get();

        return [
            'classroom_id' => $this->faker->randomElement($classroom_ids),
            'lecturer_id' => $this->faker->randomElement($lecturer_ids),
        ];
    }
}
