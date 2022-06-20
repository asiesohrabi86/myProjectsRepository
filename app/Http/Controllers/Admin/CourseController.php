<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses=Course::latest()->paginate(10);
        return view('admin.courses.courses',compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.courses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            'course'=>'required',
            'master'=>'required',
            'time'=>'required', 
            'description'=>'required',
            'image'=>'required', 
        ]);

        Course::create([
            'user_id'=>auth()->id(),
            'course'=>request('course'),
            'master'=>request('master'),
            'time'=>request('time'),
            'description'=>request('description'),
            'image'=>request('image')
        ]);

        return redirect(route('courses.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        return view('admin.courses.edit',compact('course'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        $request->validate([
            'course'=>'required',
            'master'=>'required',
            'time'=>'required',
            'description'=>'required',
            'image'=>'required'
        ]);

        $course->update([
            'course'=>request('course'),
            'master'=>request('master'),
            'time'=>request('time'),
            'description'=>request('description'),
            'image'=>request('image'),
        ]);

        return redirect(route('courses.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect(route('courses.index'));
    }
}
