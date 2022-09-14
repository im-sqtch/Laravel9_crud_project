<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function home()
    {
        $all_students = Student::get();
        return view('home', compact('all_students'));
    }

    public function formdata(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $student = new Student();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->save();

        return redirect()->route('home')->with('success', 'Subscription successful');
    }

    public function edit($id)
    {
        $single_student = Student::where('id', $id)->first();
        return view('edit', compact('single_student'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $student = Student::where('id', $id)->first();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->update();

        return redirect()->route('home')->with('success', 'Update successful');
    }

    public function delete($id)
    {
        $student = Student::where('id', $id)->first();
        $student->delete();
        return redirect()->back()->with('success', 'Delete successful');
    }
}
