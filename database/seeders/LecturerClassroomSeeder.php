<?php

namespace Database\Seeders;

use App\Models\LecturerClassroom;
use Illuminate\Database\Seeder;

class LecturerClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LecturerClassroom::factory()->count(50)->create();
    }
}
