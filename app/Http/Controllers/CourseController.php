<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Classroom;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::orderBy('semester')->paginate(15);

        return view('course.index', compact('courses'));
    }

    public function create()
    {
        $sks = ['1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4'];
        $semesters = ['1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', 
            '5'=>'5', '6'=>'6', '7'=>'7', '8'=>'8'];

        return view('course.create', compact('sks', 'semesters'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'course_code'=>'required',
            'sks'=>'required',
            'semester' => 'required'
        ]);

    	$course = new Course;
        $course->name = $request->name;
        $course->course_code = $request->course_code;
        $course->sks = $request->sks;
        $course->semester = $request->semester;
        $course->save();
            
        return redirect()->route('course.index')->with('success', 'Data successfully inserted.');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);

        $sks = ['1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4'];
        $semesters = ['1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4', 
            '5'=>'5', '6'=>'6', '7'=>'7', '8'=>'8'];
        
        return view('course.edit', compact('course', 'sks', 'semesters'));
    }

    public function update(Request $request, $id)
    {
        $course = Course::findOrFail($id);

        $request->validate([
            'name'=>'required',
            'course_code'=>'required',
            'sks'=>'required',
            'semester' => 'required'
        ]);

    	$course->name = $request->name;
        $course->course_code = $request->course_code;
        $course->sks = $request->sks;
        $course->semester = $request->semester;

        if ($course->save()) {
            return redirect()->route('course.index')->with('success', 'Data successfully updated.');
        }
    }

    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        $classroom = Classroom::where('course_id', $id)->get();

        if (!$classroom->isEmpty()) {
            return redirect()->route('course.index')
                ->with('error', "Data cannot be deleted because it's being referenced by other data.");
        } else {
            $course->delete();
            return redirect()->route('course.index')->with('success', 'Data successfully deleted.');    
        }
    }
}
