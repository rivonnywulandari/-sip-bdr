<?php

namespace Database\Seeders;

use App\Models\Lecturer;
use App\Models\User;
use Illuminate\Database\Seeder;

class LecturerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory(15)->create();
        
        foreach($users as $user){
            Lecturer::factory(1)->create(['id' => $user->id]);
        }
    }
}
