<?php

namespace Database\Factories;

use App\Models\Classroom;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassroomFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Classroom::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'classroom_code' => $this->faker->randomElement($array = array ('A','B')),
            'course_id' => 1,
            'period_id' => $this->faker->numberBetween(1, 6),
        ];
    }
}
