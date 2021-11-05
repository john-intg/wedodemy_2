<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Module;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('student.studenthome');
    }

    public function adminHome()
    {
        return view('adminHome');
    }

    public function profHome()
    {
        $modules = Module::all();
        $courses = Course::where('trainer', Auth::user()->name)->get();
        return view('prof.profHome', ['courses' => $courses, 'modules' => $modules]);
    }

}
