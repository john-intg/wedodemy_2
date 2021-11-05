<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Course extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }
	function Module(){
    	return $this->hasMany('App\Module', 'course_id', 'id' );
	}
	public function users(){
        return $this->belongsToMany('App\User', 'student_course', 'course_id', 'student_id')
        	->withTimestamps()
        	->withPivot('isApproved');
    }
    public function Approved(){
    	return $this->belongsToMany('App\User', 'student_course', 'course_id', 'student_id')->withPivot('isApproved')->wherePivot('isApproved','=', 1);
    }
    public function appointments(){
        return $this->hasMany('App\Appointment');
    }

    public function questions(){
        return $this->hasMany('App\Question');
    }
    function answers(){
        return $this->hasMany('App\Answer');
    }
    public function exams(){
        return $this->belongsToMany('App\User', 'answer_user', 'course_id', 'user_id')
            ->withTimestamps()
            ->withPivot('isPassed')
            ->orderBy('pivot_course_id', 'desc');
    }
}
