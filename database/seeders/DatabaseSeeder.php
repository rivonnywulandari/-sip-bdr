<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call([
            LecturerSeeder::class,
            StudentSeeder::class,
            ClassroomSeeder::class,
            KrsSeeder::Class,
            LecturerClassroomSeeder::class,
            ClassroomScheduleSeeder::class,
            StudentLocationSeeder::class,
            MeetingSeeder::class,
            StudentAttendanceSeeder::class,
        ]);
    }
}
