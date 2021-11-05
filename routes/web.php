<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'PageController@index');

Route::get('/courses', 'PageController@course');
Route::get('/course', 'CourseController@index')->name('courses');
Route::get('/course/{id}', 'StudentController@show')->name('course');
Route::post('/course/storeRequest', 'StudentController@enroll');
Route::post('/course/submitAssignment', 'StudentController@submitAssignment');
Route::post('/course/appointment', 'StudentController@appointment');
Route::get('/appointment', 'StudentController@appointmentIndex')->middleware('verified');
Route::get('/course/exam/{id}', 'StudentController@exam');
Route::post('/course/exam/answer', 'StudentController@answer');



Auth::routes(['verify' => true]);
Route::get('/admin/home', 'HomeController@adminHome')->name('admin.home')->middleware('is_admin');
Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::middleware(['is_prof', 'verified'])->group(function () {
	Route::get('/prof/home', 'HomeController@profHome')->name('prof.home');
	Route::get('/prof/course/create', 'CourseController@create');
	// Route::post('/prof/course/editCourse/update', 'CourseController@update');
	Route::get('/prof/course/{id}', 'CourseController@show');
	Route::post('/prof/store', 'CourseController@store');
	Route::post('/prof/publish', 'CourseController@publish');
	Route::post('/prof/unpublish', 'CourseController@unpublish');
	Route::post('/prof/update', 'CourseController@update');
	Route::get('/prof/course/deleteCourse/{id}', 'CourseController@deleteCourse');

	Route::post('/prof/course/editModule', 'CourseController@editModule');
	Route::get('/prof/course/deleteModule/{id}', 'CourseController@deleteModule');
	Route::post('/prof/course/addModule', 'CourseController@addModule');

	Route::get('/prof/course/exam/{id}', 'ExamController@show');
	Route::post('/prof/course/exam/addQuestion', 'ExamController@store');
	Route::post('/prof/course/exam/updateQuestion', 'ExamController@update');
	Route::post('/prof/course/exam/destroyQuestion/{id}', 'ExamController@destroy');

	Route::post('/prof/course/exam/addChoice', 'ExamController@storeChoice');
	Route::post('/prof/course/exam/destroyChoice/{id}', 'ExamController@destroyChoice');
	Route::post('/prof/course/exam/updateChoice/{id}', 'ExamController@updateChoice');

	Route::get('/prof/approval', 'CourseController@approvalIndex');
	Route::post('/prof/acceptEnrolee', 'CourseController@acceptEnrolee');
	Route::post('/prof/declineEnrolee', 'CourseController@declineEnrolee');

	Route::get('/prof/appointment', 'AppointmentController@index');
	Route::post('/prof/doneAppointment', 'AppointmentController@doneAppointment');
	Route::post('/prof/confirmAppointment', 'AppointmentController@confirmAppointment');
	Route::post('/prof/declineAppointment', 'AppointmentController@declineAppointment');

	Route::get('/prof/answers', 'ExamController@answers');
	Route::post('/prof/answer', 'ExamController@answer');


});