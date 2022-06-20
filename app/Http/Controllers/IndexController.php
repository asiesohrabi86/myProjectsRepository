<?php

namespace App\Http\Controllers;

use App\Models\Calendar;
use App\Models\ContactUs;
use App\Models\Course;
use App\Models\Master;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
        $courses=Course::latest()->take(4)->get();
        $sliders=Slider::latest()->get();
        $users=User::latest()->take(4)->get();
        $masters=Master::latest()->take(4)->get();
        return view('index',compact(['courses','users','sliders','masters']));
    }

    public function singlecourse(Course $course)
    {
        return view('single-course',compact('course'));
    }

    public function singlemaster(Master $master)
    {
        return view('single-master',compact('master'));
    }
    
    public function showCalendar()
    {
        $calendars=Calendar::latest()->get();
        return view('calendar',compact('calendars'));
    }

    public function showAboutus()
    {
        return view('aboutus');
    }

    public function showContactus()
    {
        return view('contactus');
    }

    public function search(Request $request)
    {
        $course=Course::where('course','LIKE',"%{$request->search}%")->orWhere('master','LIKE',"%{$request->search}%")->first();
        return view('single-course',compact('course'));
    }

    public function postForm(Request $request)
    {
        $data=$request->validate([
            'name'=>['required','string','max:255'],
            'email'=>'required',
            'tel'=>['required','string','max:255'],
            'subject'=>['required','string','max:255'],
            'description'=>'required',
        ]);

        ContactUs::create($data);
        return back();
    }

}
