<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
         $this->middleware(['auth','verified','auth.admin']);
    }
    
    public function index()
    {
        return view('dashboard.home');
    }
}
