<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\Krs;
use Illuminate\Database\Seeder;

class KrsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Krs::truncate();
        
        $students = Student::where('id', '<=', '20')->get();

        foreach($students as $student){
            Krs::factory(3)->create(['student_id' => $student->id]);
        }
    }
}
