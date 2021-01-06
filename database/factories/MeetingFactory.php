<?php

namespace Database\Factories;

use Faker\Factory as Faker;
use Carbon\Carbon;
use App\Models\Meeting;
use App\Models\LecturerClassroom;
use Illuminate\Database\Eloquent\Factories\Factory;

class MeetingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Meeting::class;

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
        $lecturer_classroom_ids = LecturerClassroom::select('id')->get();

        return [
            'number_of_meeting' => $this->faker->unique()->numberBetween(17, 30),
            'date' => $this->faker->unique()->dateTimeThisYear()->format('Y-m-d'),
            'start_time' => $start_time,
            'finish_time' => $finish_time,
            'lecturer_classroom_id' => $this->faker->randomElement($array = array (30,20)),
        ];
    }
}
