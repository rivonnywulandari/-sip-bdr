<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Lecturer;
use App\Models\Student;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UserStudentImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            if (isset($row[1]) != null) {
                $user = User::create([
                    'username' => $row[3],
                    'email' => $row[4],
                    'password' => $row[5]
                ]);

                $lecturer_id = Lecturer::where('name', $row[6])->value('id');
                Student::create([
                    'id' => $user->id,
                    'nim' => $row[1],
                    'name' => $row[2],
                    'lecturer_id' => $lecturer_id
                ]);
            }
        }
    }
}
