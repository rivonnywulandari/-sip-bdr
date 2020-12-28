<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Database\Seeder;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory(60)->create();

        foreach($users as $user){
            Student::factory(1)->create(['id' => $user->id]);
        }
    }
}
