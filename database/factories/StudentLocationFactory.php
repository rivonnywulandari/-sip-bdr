<?php

namespace Database\Factories;

use App\Models\StudentLocation;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentLocationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = StudentLocation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'longitude' => $this->faker->longitude($min = 100, $max = 114),
            'latitude' => $this->faker->latitude($min = -1, $max = 7),
            'address' => $this->faker->address,
            'student_id' => 1,
            'submission_status' => 'Disetujui',
        ];
    }
}
