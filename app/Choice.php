<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    public function question(){
    	return $this->belongsTo('App\Question');
    }
    function answers(){
        return $this->hasMany('App\Answer');
    }
}
