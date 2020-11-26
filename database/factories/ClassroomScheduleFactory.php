<?php

namespace Database\Factories;

use Faker\Factory as Faker;
use Carbon\Carbon;
use App\Models\ClassroomSchedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class ClassroomScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ClassroomSchedule::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create();
        $hour = $faker->dateTimeBetween('07:30:00', '16:00:00')->format('H');
        $minute = $faker->dateTimeBetween('07:00:00', '07:30:00')->format('i');
        $second = $faker->dateTimeBetween('07:00:00', '07:00:00')->format('s');
        $start_time = Carbon::createFromTime($hour, $minute, $second);
        $finish_time = Carbon::parse($start_time)->addHours(2);
        
        return [
            'scheduled_day' => $this->faker->dayOfWeek(),
            'start_time' => $start_time,
            'finish_time' => $finish_time,
            'classroom_id' => 1,
        ];
    }
}
