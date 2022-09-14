<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function home()
    {
        return view('home');
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
    }
}
