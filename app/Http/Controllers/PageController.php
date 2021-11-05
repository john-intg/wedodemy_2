<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use App\Module;

class PageController extends Controller
{
    public function index(){
    	return view('pages.index');
    }

    public function course(){
    	$modules = Module::all();
        $courses = Course::where('publish', '1')->get();

        // $courses = Course::all();

        // $courses = DB::table('courses')->leftjoin('modules', 'courses.id', 'modules.course_id')->get();

        // echo "<pre>";
        // print_r($modules);
        return view('courses', ['courses' => $courses, 'modules' => $modules]);
    }
}
