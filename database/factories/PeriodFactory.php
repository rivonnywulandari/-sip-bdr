<?php

namespace Database\Factories;

use App\Models\Period;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeriodFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Period::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'year' => $this->faker->randomElement($array = array ('2018/2019','2019/2020','2020/2021')),
            'semester' => $this->faker->randomElement($array = array ('Ganjil','Genap')),
        ];
    }
}
