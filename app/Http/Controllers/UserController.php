<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Lecturer;
use App\Models\LecturerClassroom;
use App\Models\Krs;
use App\Imports\UserStudentImport;
use App\Imports\UserLecturerImport;
use Excel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'DESC')->paginate(50);
        $type = ['Mahasiswa'=>'Mahasiswa', 'Dosen'=>'Dosen'];

        return view('user.index', compact('users', 'type'));
    }

    public function import(Request $request) {
        $this->validate($request, [
            'type' => 'required',
            'report_file'  => 'required|mimes:xls,xlsx'
        ]);

        $file = $request->file('report_file');
        $path = $file->storeAs('public/data_user', $file->getClientOriginalName());
        if ($request->type == "Mahasiswa") {
            Excel::import(new UserStudentImport, $path);
        } else if ($request->type == "Dosen") {
            Excel::import(new UserLecturerImport, $path);
        }
        return back()->with('success', 'Excel data successfully imported.');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        if(isset($user->lecturer->id)) {
            $guidance_students = $user->lecturer->student()
                ->select('students.name')
                ->get();
            
            return view('user.show', compact('user', 'guidance_students'));
        } else {
            return view('user.show', compact('user'));
        }
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        $lecturers = Lecturer::all()->sortBy('name')->pluck('name','id');
        
        return view('user.edit', compact('user', 'lecturers'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        if(isset($user->lecturer->id)) {
            $lecturer = Lecturer::findOrFail($id);
        } else if (isset($user->student->id)) {
            $student = Student::findOrFail($id);
        }

        $request->validate([
            'username'=>'required',
            'email'=>'required'
        ]);

        if(isset($lecturer->id)) {
            $request->validate([
                'name'=>'required',
                'nip'=>'required'
            ]);
        } else if (isset($student->id)) {
            $request->validate([
                'name'=>'required',
                'nim'=>'required',
                'lecturer_id'=>'required'
            ]);
        }

    	$user->username = $request->username;
        $user->email = $request->email;
        if(isset($lecturer->id)) {
            $lecturer->name = $request->name;
            $lecturer->nip = $request->nip;
            if ($user->save() && $lecturer->save()) {
                return redirect()->route('user.index')->with('success', 'Data successfully updated.');
            }

        } else if (isset($student->id)) {
            $student->name = $request->name;
            $student->nim = $request->nim;
            $student->lecturer_id = $request->lecturer_id;
            if ($user->save() && $student->save()) {
                return redirect()->route('user.index')->with('success', 'Data successfully updated.');
            }
        } else {
            if ($user->save()) {
                return redirect()->route('user.index')->with('success', 'Data successfully updated.');
            }
        }
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if(isset($user->lecturer->id)) {
            $lecturer = Lecturer::findOrFail($id);
        } else if (isset($user->student->id)) {
            $student = Student::findOrFail($id);
        }
        $krs = Krs::where('student_id', $id)->get();
        $lecturer_classroom = LecturerClassroom::where('lecturer_id', $id)->get();
        $guidance_student = Student::where('lecturer_id', $id)->get();

        if ($krs->isEmpty() && $lecturer_classroom->isEmpty() && $guidance_student->isEmpty()) {
            if (isset($lecturer->id)) {
                $lecturer->delete();
            } else if (isset($student->id)) {
                $student->delete();
            }
            $user->delete();
            return redirect()->route('user.index')->with('success', 'Data successfully deleted.');    
        } else {
            return redirect()->route('user.index')
                ->with('error', "Data cannot be deleted because it's being referenced by other data.");
        } 
    }
}
