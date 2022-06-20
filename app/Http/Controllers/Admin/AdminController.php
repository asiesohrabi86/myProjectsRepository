<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Master;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    
    public function index()
    {
       $user_count=User::count();
       $master_count=Master::count();
       $course_count=Course::count();
        return view('admin.index',compact(['user_count','master_count','course_count']));
    }
}
