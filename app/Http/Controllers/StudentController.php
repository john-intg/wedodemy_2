<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Course;
use App\User;
use App\Module;
use App\Appointment;
use App\Choice;
use App\Answer;
use Auth;


class StudentController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }
    public function enroll(Request $request){
        $student =\App\User::find($request->student);
        // $course = \App\Course::find($request->course);

        $student->courses()->attach([
            $request->course => [
                'isApproved' => false,
            ]
        ]);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $user = User::find(Auth::id())->modules->where('course_id', $id);
        // return User::find($id)->courses->first();
        $approval = Course::join('student_course', 'courses.id', 'student_course.course_id')
            ->join('users', 'student_course.student_id', 'users.id')
            ->where('courses.id', $id)
            ->where('student_id', Auth::id())->first();
        // return  Course::find($id)->users->where('course_id', [Auth::id()])->get();
            // $course_requests = Course::firstWhere('user_id', 2)->Approved->all();
        $firstModule = Course::find($id)->Module->first();
        $lastModule = Course::find($id)->Module->last();

        // $lastModule = $module->where('course_id', $module->course_id)->orderBy('module_id', 'desc')->first();
        $modules = Course::find($id)->Module->all();
        // return User::find(Auth::id())->modules->where('course_id', $id)->all();
        // return $firstModule->where('module_id', '>', $firstModule->module_id)->orderBy('module_id')->first();
        $next = Module::where('module_id', '>', $firstModule->module_id)->orderBy('module_id')->first();
        $course = Course::find($id);
        $appointment = Appointment::where('course_id', $id)->where('user_id', Auth::id());
        $allAppointment = $appointment->get();
        $firstAppointment = $appointment->first();
        $lastAppointment =  $allAppointment->last();


        return view('student.course', ['course' => $course, 'firstModule' => $firstModule, 'lastModule' => $lastModule, 'modules' => $modules, 'approval' => $approval, 'next' => $next, 'user' => $user, 'allAppointment'=> $allAppointment, 'firstAppointment' => $firstAppointment, 'lastAppointment' => $lastAppointment]);
    }

    public function submitAssignment(Request $request){
        $module = User::find($request->user_id);

        $module->modules()->attach([
            $request->module_id =>[
                'link'=> $request->link,
            ]
        ]);
        return back();
    }

    public function appointment(Request $request){
        $appointment = new Appointment;

        $appointment->user_id = Auth::id();
        $appointment->course_id = $request->course_id;
        $appointment->appointment_date = $request->appointment_date;
        $appointment->save();
        return back();
    }

    public function appointmentIndex()
    {
        
        $appointments = Appointment::where('user_id', Auth::id())->where('appointment_confirm', 1)->where('appointment_done', 0)->get();
        return view('student.appointment', ['appointments' => $appointments]);
    }

    public function exam($id)
    {
        // $choice = Choice::where('id', 'asdasd')->pluck('correct_choice')->first();
        // if (isset($choice)) {
        //     if ($choice ==1 ) {
        //        echo "Correct Answer!!!";
        //     }else{
        //         echo "youre wrong loser";
        //     }
        // }else{
        //     echo "string";
        // }
        $course = Course::find($id);
        // $questions = Course::find($id)->questions->first()->with('choices')->get();
        // 'questions' => $questions,
        return view('student.exam', [ 'course' => $course]);
    }

    public function answer(Request $request){
        // return $request;
        $course_id = $request->course_id;
        $user_id = Auth::id();

        if (isset($request->answer)) {
            foreach ($request->answer as $key => $value) {
                $answer = new Answer;

                $answer->user_id = $user_id;
                $answer->course_id = $course_id;
                $answer->answer = $value;
                $answer->question_id = $key;

                 $answer->save();
            }
        }
        
        if (isset($request->choice_id)) {
            foreach ($request->choice_id as $key => $value) {
            
                if (is_array($value)) {
                    foreach ($value as $keys => $values) {

                        $answer = new Answer;
                        $choice = Choice::where('id', $values)->pluck('correct_choice')->first();
                        $answer->user_id = $user_id;
                        $answer->course_id = $course_id;
                        $answer->choice_id = $values;
                        $answer->question_id = $key;
                        if ($choice ==1 ) {
                           $answer->is_correct = 1;
                        }else{
                           $answer->is_correct = 0;
                        }
                        $answer->save();
                    }
                }else{
                    $choice = Choice::where('id', $value)->pluck('correct_choice')->first();
                    $answer = new Answer;
                    $answer->user_id = $user_id;
                    $answer->course_id = $course_id;
                    $answer->choice_id = $value;
                    $answer->question_id = $key;
                    if ($choice ==1 ) {
                       $answer->is_correct = 1;
                    }else{
                       $answer->is_correct = 0;
                    }
                    $answer->save();
                }
             
            }
        }

        $student =\App\User::find(Auth::id());
        // $course = \App\Course::find($request->course);

        $student->exams()->attach([
            $course_id => [
                'isPassed' => null,
            ]
        ]);
       
        return redirect('course');
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
