<?php

namespace App\Imports;

use App\Models\Period;
use App\Models\Course;
use App\Models\Classroom;
use App\Models\ClassroomSchedule;
use App\Models\Lecturer;
use App\Models\LecturerClassroom;
use App\Models\Student;
use App\Models\Krs;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ClassroomImport implements ToCollection
{
    /**
    * @param Collection $collection
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            if (isset($row[1]) != null) {
                $period_id = Period::where('year', $row[1])
                    ->where('semester', $row[2])->value('id');

                $course_id = Course::where('name', $row[3])->value('id');
            }

            if (isset($row[4]) != null && $period_id && $course_id) {
                $classroom = Classroom::create([
                    'classroom_code' => $row[4],
                    'period_id' => $period_id,
                    'course_id' => $course_id,
                ]);
            }

            if (isset($row[5]) != null && $classroom->id) {
                ClassroomSchedule::create([
                    'classroom_id' => $classroom->id,
                    'scheduled_day' => $row[5],
                    'start_time' => $row[6],
                    'finish_time' => $row[7],
                ]);
            }

            if (isset($row[8]) != null && $classroom->id) {
                $lecturer_id = Lecturer::where('name', $row[8])->value('id');

                $lecturer_classroom = LecturerClassroom::create([
                    'classroom_id' => $classroom->id,
                    'lecturer_id' => $lecturer_id,
                ]);
            }

            if (isset($row[9]) != null && $classroom->id) {
                $student_id = Student::where('nim', $row[9])
                    ->where('name', $row[10])->value('id');

                $krs = Krs::create([
                    'classroom_id' => $classroom->id,
                    'student_id' => $student_id,
                ]);
            }
        }
    }
}
