<?php

namespace Database\Factories;

use App\Models\Krs;
use Illuminate\Database\Eloquent\Factories\Factory;

class KrsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Krs::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'student_id' => 1,
            'classroom_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
