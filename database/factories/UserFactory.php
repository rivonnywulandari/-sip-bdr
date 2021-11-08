<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'username' => $this->faker->unique()->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
//            'password' => $this->faker->password,
            'password' => bcrypt('12345'),
            'remember_token' => Str::random(10),
        ];
    }
}
