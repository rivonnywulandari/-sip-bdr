<?php

namespace Database\Factories;

use App\Models\LecturerClassroom;
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
        return [
            'classroom_id' => $this->faker->numberBetween(1, 10),
            'lecturer_id' => 1,
        ];
    }
}
