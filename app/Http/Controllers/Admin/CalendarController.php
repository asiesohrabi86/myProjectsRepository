<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Calendar;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $calendars=Calendar::latest()->paginate(10);
        return view('admin.calendars.calendars',compact('calendars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.calendars.create');
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
            'teacher'=>'required',
            'time'=>'required', 
            'capacity'=>'required',
            'cost'=>'required', 
            'startingtime'=>'required', 
        ]);

        auth()->user()->calendar()->create([
            'course'=>request('course'),
            'teacher'=>request('teacher'),
            'time'=>request('time'),
            'capacity'=>request('capacity'),
            'cost'=>request('cost'),
            'startingtime'=>request('startingtime')
        ]);

        return redirect(route('calendars.index'));
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
    public function edit(Calendar $calendar)
    {
        return view('admin.calendars.edit',compact('calendar'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Calendar $calendar)
    {
        $request->validate([

            'course'=>'required',
            'teacher'=>'required',
            'time'=>'required', 
            'capacity'=>'required',
            'cost'=>'required', 
            'startingtime'=>'required', 
        ]);
        $calendar->update([
            'course'=>request('course'),
            'teacher'=>request('teacher'),
            'time'=>request('time'),
            'capacity'=>request('capacity'),
            'cost'=>request('cost'),
            'startingtime'=>request('startingtime')
        ]);
        return redirect(route('calendars.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Calendar $calendar)
    {
        $calendar->delete();
        return back();
    }
}
