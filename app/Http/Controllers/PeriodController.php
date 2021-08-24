<?php

namespace App\Http\Controllers;

use App\Models\Period;
use App\Models\Classroom;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    public function index()
    {
        $periods = Period::orderBy('id', 'DESC')->paginate(15);

        return view('period.index', compact('periods'));
    }

    public function create()
    {
        $semesters = ['Ganjil'=>'Ganjil', 'Genap'=>'Genap'];
        
        return view('period.create', compact('semesters'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'year'=>'required',
            'semester' => 'required'
        ]);

    	$period = new Period;
        $period->year = $request->year;
        $period->semester = $request->semester;
        $period->save();
            
        return redirect()->route('period.index')->with('success', 'Data successfully inserted.');
    }

    public function edit($id)
    {
        $period = Period::findOrFail($id);

        $semesters = ['Ganjil'=>'Ganjil', 'Genap'=>'Genap'];
        
        return view('period.edit', compact('period', 'semesters'));
    }

    public function update(Request $request, $id)
    {
        $period = Period::findOrFail($id);

        $request->validate([
            'year'=>'required',
            'semester' => 'required'
        ]);

        $period->year = $request->year;
        $period->semester = $request->semester;

        if($period->save()) {
            return redirect()->route('period.index')->with('success', 'Data successfully updated.');
        }
    }

    public function destroy($id)
    {
        $period = Period::findOrFail($id);
        $classroom = Classroom::where('period_id', $id)->get();

        if (!$classroom->isEmpty()) {
            return redirect()->route('period.index')
                ->with('error', "Data cannot be deleted because it's being referenced by other data.");
        } else {
            $period->delete();
            return redirect()->route('period.index')->with('success', 'Data successfully deleted.');    
        }
    }
}
