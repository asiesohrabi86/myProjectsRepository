<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SweetAlert;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class IndexController extends Controller
{
    public function index()
    {
        // $role = Role::create(['name' => 'writer']);
        // $permission = Permission::create(['name' => 'edit articles']);
        // auth()->user()->assignRole('writer');
        alert()->success('متن تست','متن عنوان تست')->persistent('خیلی خوب');
        return view('index');
    }
}
