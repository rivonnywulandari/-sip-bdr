<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
             LecturerSeeder::class,
             StudentSeeder::class,
             ClassroomSeeder::class,
             ClassroomScheduleSeeder::class,
             KrsSeeder::class,
             LecturerClassroomSeeder::class,
             StudentLocationSeeder::class,
             MeetingSeeder::class,
//             StudentAttendanceSeeder::class,
             AddTopicSeeder::class,
        ]);
    }
}
