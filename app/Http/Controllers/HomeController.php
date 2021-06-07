<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Classroom;
use Illuminate\Http\Request;
use DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application home.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $periods = Period::all()->sortByDesc('id')->pluck('period', 'id');

        return view('pages.home', compact('periods'));
    }

    /**
     * Select submenu classroom based on selected period.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function classrooms($id)
    {
        $classrooms = Classroom::query()
                    ->join('courses', 'courses.id', '=', 'classrooms.course_id')
                    ->select(DB::raw("CONCAT(courses.name, ' Kelas ', classrooms.classroom_code) AS classroom_name"), 'classrooms.id')
                    ->where('period_id', $id)
                    ->pluck('classroom_name', 'classrooms.id');

        return json_encode($classrooms);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = $request->input('classroom');
        $classroom = Classroom::findOrFail($id);

        return redirect()->route('classroom.show', [$classroom->id, 'show']);
    }
}
