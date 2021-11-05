<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'is_prof', 'is_admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function courses(){
        return $this->belongsToMany('App\Course', 'student_course', 'student_id','course_id')
            ->withTimestamps()
            ->withPivot('isApproved');
    }

    public function modules(){
        return $this->belongsToMany('App\Module', 'module_user', 'user_id','module_id')
            ->withTimestamps()
            ->withPivot('link')
            ->orderBy('module_id','DESC');
    }
    public function withlinks(){
        return $this->belongsToMany('App\Module', 'module_user', 'user_id','module_id')
            ->withTimestamps()
            ->withPivot('link')
            ->wherePivot('link', '!=',null);
    }

    public function Approved(){
        return $this->belongsToMany('App\User', 'student_course', 'student_id', 'course_id')->withPivot('isApproved')->wherePivot('isApproved', '=', 1);
    }
    public function isNotApproved(){
        return $this->belongsToMany('App\User', 'student_course', 'student_id', 'course_id')->withPivot('isApproved')->wherePivot('isApproved','=', 0);
    }
    function course(){
        return $this->hasMany('App\Course');
    }
    function answers(){
        return $this->hasMany('App\Answer');
    }

    public function exams(){
        return $this->belongsToMany('App\Course', 'answer_user', 'user_id','course_id')
            ->withTimestamps()
            ->withPivot('isPassed');
    }
}

