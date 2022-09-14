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
}
