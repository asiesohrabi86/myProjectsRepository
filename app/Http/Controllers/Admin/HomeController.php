<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function __construct()
    {
         $this->middleware(['auth','verified','auth.admin']);
    }
    
    public function index()
    {
        return Inertia::render('AdminDashboard/Dashboard', [
            // داده‌های مورد نیاز
        ]);
    }
}
