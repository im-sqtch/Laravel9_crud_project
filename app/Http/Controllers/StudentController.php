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
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required',
            'email' => 'required|email'
        ]);

        $extension = $request->file('photo')->extension();
        $final_name = date('YmdHis').'.'.$extension;

        $request->file('photo')->move(public_path('uploads/'),$final_name);

        //dd($final_name);

        $student = new Student();
        $student->photo = $final_name;
        $student->name = $request->name;
        $student->email = $request->email;
        $student->save();

        return redirect()->route('home')->with('success', 'Subscription successful.');
    }

    public function edit($id)
    {
        $single_student = Student::where('id',$id)->first();
        return view('edit', compact('single_student'));
    }

    public function update(Request $request,$id)
    {
        $student = Student::where('id',$id)->first();

        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        if($request->hasFile('photo'))
        {
            $request->validate([
                'photo' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            if(file_exists(public_path('uploads/'.$student->photo)) AND !empty($student->photo))
            {
                unlink(public_path('uploads/'.$student->photo));
            }

            $extension = $request->file('photo')->extension();
            $final_name = date('YmdHis').'.'.$extension;

            $request->file('photo')->move(public_path('uploads/'),$final_name);

            $student->photo = $final_name;
        }

        $student->name = $request->name;
        $student->email = $request->email;
        $student->update();

        return redirect()->route('home')->with('success', 'Update successful.');
    }

    public function delete($id)
    {
        $student = Student::where('id',$id)->first();

        if(file_exists(public_path('uploads/'.$student->photo)) AND !empty($student->photo))
            {
                unlink(public_path('uploads/'.$student->photo));
            }

        $student->delete();

        return redirect()->back()->with('success','Delete successful.');
    }
}