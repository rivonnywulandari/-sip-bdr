<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Lecturer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class UserLecturerImport implements ToCollection
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
                    'password' => $row[5],
                    'nip' => $row[1],
                    'name' => $row[2]
                ]);

                Lecturer::create([
                    'id' => $user->id,
                    'nip' => $row[1],
                    'name' => $row[2]
                ]);
            }
        }
    }
}
