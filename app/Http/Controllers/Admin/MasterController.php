<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Master;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $masters=Master::latest()->get();
        return view('admin.masters.masters',compact('masters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.masters.create');
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
            'name'=>['required','string','max:255'],
            'antecedent'=>['required','string','max:255'],
            'field'=>['required','string','max:255'],
            'image'=>['required','string','max:255'],
        ]);
        
        Master::create([
            'user_id'=>auth()->id(),
            'name'=>request('name'),
            'antecedent'=>request('antecedent'),
            'field'=>request('field'),
            'image'=>request('image'),
        ]);

        return redirect(route('masters.index'));
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
    public function edit(Master $master)
    {
        return view('admin.masters.edit',compact('master'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Master $master)
    {
        $request->validate([
            'name'=>['required','string','max:255'],
            'antecedent'=>['required','string','max:255'],
            'field'=>['required','string','max:255'],
           
            'image'=>['required','string','max:255'],
        ]);

        $master->update([   
            'name'=>request('name'),
            'antecedent'=>request('antecedent'),
            'field'=>request('field'),
           
            'image'=>request('image'),
        ]);

        return redirect(route('masters.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Master $master)
    {
        $master->delete();
        return redirect(route('masters.index'));
    }
}
