<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\Lecturer;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Student::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lecturer_ids = Lecturer::select('id')->get();

        return [
            'id' => 1,
            'name' => $this->faker->name,
            'nim' => $this->faker->numerify('1#1152#0##'),
            'lecturer_id' => $this->faker->randomElement($lecturer_ids),
        ];
    }
}
