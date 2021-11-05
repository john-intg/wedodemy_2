<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Course;
use App\User;
use Auth;
use App\Module;
use App\Choice;
use App\Question;

class CourseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    
    
    public function index()
    {
        
        $modules = Module::all();
        $yourcourses = Course::where('trainer', Auth::user()->name)->where('publish', '1')->get();
        $courses = Course::whereNotIn('trainer', [Auth::user()->name])->where('publish', '1')->get();

        // $courses = Course::all();

        // $courses = DB::table('courses')->leftjoin('modules', 'courses.id', 'modules.course_id')->get();

        // echo "<pre>";
        // print_r($modules);
        return view('courses.index', ['courses' => $courses, 'modules' => $modules, 'yourcourses' => $yourcourses]); 
        // return DB::table('users')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('courses.create_course');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->hasFile('thumbnail')) {
            //Get file name w/ the extension
            $fileNameWithExt = $request->file('thumbnail')->getClientOriginalName();
            //get just file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //get Extension
            $extension = $request->file('thumbnail')->getClientOriginalExtension();
            //file name to store
            $fileNameToStoreThumbnail = $fileName.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('thumbnail')->storeAs('public/'.Auth::user()->name.'/thumbnails', $fileNameToStoreThumbnail);
        }


        $course = new Course;
        $course->user_id = $request->user_id;
        $course->title = $request->title;
        $course->trainer = $request->trainer;
        $course->thumbnail = $fileNameToStoreThumbnail;
        $course->about = $request->about;
        $course->save();
        return back();
    }

    public function editCourse($id){
        $course = Course::find($id);
        return view('courses.edit_course')->with('course', $course);
    }

    public function update(Request $request){
        $course = Course::find($request->id);
        $course->title = $request->title;
        $course->about = $request->about;
        $course->save();
        return back();
    }

    public function publish(Request $request){
        $course = Course::find($request->id);
        $course->publish = $request->publish;
        $course->save();
        return back();
    }
    public function unpublish(Request $request){
        $course = Course::find($request->id);
        $course->publish = $request->publish;
        $course->save();
        return back();
    }

    public function deleteCourse($id){
        $course = Course::find($id);
        $module = Module::where('course_id', $id);
        $course->delete();
        $module->delete();
        Storage::deleteDirectory('public/'.$course->trainer.'/'.$course->id);
        return back();

    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show()

    public function show($id)
    {
        $course = Course::find($id); 
        $modules = DB::table('modules')->get()->where('course_id', $id);
        $first_module = DB::table('modules')->get()->firstWhere('course_id', $id);

        $questions = Question::all()->where('course_id', $id);
        $choices = Choice::all();
        return view('courses.course', ['course'=> $course, 'modules'=> $modules, 'first_module' => $first_module, 'questions' => $questions, 'choices' => $choices]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editModule(Request $request)
    {
        if ($request->hasFile('updateModuleVideo')) {
            //Get file name w/ the extension
            $fileNameWithExt = $request->file('updateModuleVideo')->getClientOriginalName();
            //get just file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //get Extension
            $extension = $request->file('updateModuleVideo')->getClientOriginalExtension();
            //file name to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('updateModuleVideo')->storeAs('public/'.$request->course_trainer.'/'.$request->course_id, $fileNameToStore);
        }

        $module = Module::find($request->updateModuleId);
        $module->module_name = $request->updateModuleName;
        $module->module_assignment = $request->updateModuleAssignment;
        if ($request->hasFile('updateModuleVideo')) {
            $module->module_video = $fileNameToStore;
        }
        $module->save();
        return back();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request)

    public function addModule(Request $request)
    {
        // $this->validate($request, [
        //     'module_video' => 'required|mimes:mp4,avi',
        // ]);

        //Handle File Upload
        if ($request->hasFile('module')) {
            //Get file name w/ the extension
            $fileNameWithExt = $request->file('module')->getClientOriginalName();
            //get just file name
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //get Extension
            $extension = $request->file('module')->getClientOriginalExtension();
            //file name to store
            $fileNameToStore = $fileName.'_'.time().'.'.$extension;
            //upload image
            $path = $request->file('module')->storeAs('public/'.$request->course_trainer.'/'.$request->course_id, $fileNameToStore);
        }

        $module = new Module;
        $module->module_name = $request->module_name;
        $module->course_id = $request->course_id;
        $module->module_assignment = $request->module_assignment;
        $module->module_video = $fileNameToStore;
        $module->save();
        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteModule($id)
    {
        $module = Module::find($id); 
        $course = Course::find($module->course_id);
        $module->delete();
        Storage::delete('public/'.$course->trainer.'/'.$course->id.'/'.$module->module_video);
        return back();
        // $modulesCourse = $module->where('course_id', $module->course_id);
        // $modulesCourse->delete();
        // Storage::deleteDirectory('public/'.$course->trainer.'/'.$course->id);
    }

    public function approvalIndex(){
        // return Course::find(1)->users->wherePivot('asApproved', 1);
        // $course_requests = Course::firstWhere('user_id', 2)->with('Approved')->get();
        $course_requests = DB::table('courses')
            ->join('student_course', 'courses.id', 'student_course.course_id')
            ->join('users', 'student_course.student_id', 'users.id')
            ->where('trainer', Auth::user()->name)
            ->where('isApproved', '0')->get();
        return view('prof.approval', ['course_requests' => $course_requests]);
        // $request = DB::table('student_course')->where('isApproved', '0')->pluck('course_id')->all();
        // $requests = Course::whereIn('id', $request)->where('trainer', Auth::user()->name)->get();
        // $approved = DB::table('student_course')->where('isApproved', '1')->pluck('course_id')->all();
        // $requesters = DB::table('student_course')->where('isApproved', '0')->pluck('student_id')->all();
        // $courses_approveds = Course::whereIn('id', $approved)->where('trainer', Auth::user()->name)->get();
        // return Course::select('id')
        //     ->where('trainer', Auth::user()->name)
        //     ->where
        //     ->get();
        // return Course::select('id')->where('trainer', Auth::user()->name)->first()->Approved()->get();
        // dd(Course::find(1)->users->first()->pivot->isApproved);
        // return Course::firstWhere('trainer', Auth::user()->name)->users;
        
        // return Course::with('users')->get()->where('trainer', Auth::user()->name);
    }

    public function acceptEnrolee(Request $request){
        // return Course::find(1);
        DB::table('student_course')
            ->where('student_id', $request->student_id)
            ->where('course_id', $request->course_id)
            ->update(['isApproved' => true]);
        return back();
    }

    public function declineEnrolee(Request $request){
        DB::table('student_course')
            ->where('student_id', $request->student_id)
            ->where('course_id', $request->course_id)
            ->delete();
        return back();
    }
}
