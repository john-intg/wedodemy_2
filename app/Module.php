<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $table ='modules';
    protected $primaryKey = 'module_id';

    public function users(){
        return $this->belongsToMany('App\User', 'module_user', 'module_id', 'user_id')
        	->withTimestamps()
        	->withPivot('link');
    }
}
