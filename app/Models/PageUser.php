<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageUser extends Model
{
    //

    protected $table='page_users';

    protected $fillable = array('page_id','post_id','created_by','scheduled_publish_time');


    public function Detail(){

		return $this->hasMany('App\Models\OrderDetail','parent_id');		
	}

	public function User(){

		return $this->hasOne('App\User','id','user_id');		

	}

	public function Page(){

		return $this->hasOne('App\Models\Page','page_id','page_id');		

	}
	
	public function Comment(){

		return $this->hasMany('App\Models\Comment','post_id','post_id')->orderBy('comments.created_at','DESC');		

	}

}
