<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //

    protected $table='comments';

    protected $fillable = array('post_id','created_by','message','via');


    public function Detail(){

		return $this->hasMany('App\Models\OrderDetail','parent_id');		
	}

	public function Page(){

		return $this->hasOne('App\Models\OrderDetail','parent_id');			
	}

}
