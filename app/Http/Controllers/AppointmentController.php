<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Course;
use App\Appointment;
use Auth;

class AppointmentController extends Controller
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
        // $appointments = User::find(Auth::id())->course->first()->with('appointments')->get();
        $courses = Course::where('user_id', Auth::id())->get();
        // $appointments = User::find(Auth::id())->course->first()->appointments->where('appointment_done', 0);
        // $requestAppointments = User::find(Auth::id())->course->first()->appointments->where('appointment_confirm', 0);
        // $confirmedAppointments = User::find(Auth::id())->course->first()->appointments->where('appointment_confirm', 1);

        return view('prof.appointment', ['courses' => $courses]);
    }

    public function confirmAppointment(Request $request){
        $appointment = Appointment::find($request->id);
        $appointment->appointment_confirm = 1;
        $appointment->save();
        return back();
    }

    public function doneAppointment(Request $request){
        $appointment = Appointment::find($request->id);
        $appointment->appointment_done = 1;
        $appointment->save();
        return back();
    }

    public function declineAppointment(Request $request){
        $appointment = Appointment::find($request->id);
        $appointment->delete();
        return back();
    }
}