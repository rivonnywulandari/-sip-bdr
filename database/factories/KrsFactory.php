<?php

namespace Database\Factories;

use App\Models\Krs;
use App\Models\Student;
use App\Models\Classroom;
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
        $student_ids = Student::select('id')->get();
        $classroom_ids = Classroom::select('id')->get();

        return [
            'student_id' => $this->faker->randomElement($student_ids),
            'classroom_id' => $this->faker->randomElement($classroom_ids),
        ];
    }
}
