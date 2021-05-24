<?php

namespace Database\Seeders;

use App\Models\Meeting;
use DB;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class AddTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        DB::table('meetings')->update([
            'topic' => $faker->catchPhrase
        ]);
    }
}
