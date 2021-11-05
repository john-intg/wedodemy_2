<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    public function course(){
    	return $this->belongsTo('App\Course');
    }

    public function choices(){
    	return $this->hasMany('App\Choice');
    }
    function answers(){
        return $this->hasMany('App\Answer');
    }
}
