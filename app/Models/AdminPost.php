<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminPost extends Model
{
    //

    protected $table='admin_posts';

    protected $fillable = array('page_id','post_id','created_by','post_time','message','image_path','budget','currency','translate');


    public function Detail(){

		return $this->hasMany('App\Models\OrderDetail','parent_id');		
	}

	public function Page(){

		return $this->hasOne('App\Models\Page','page_id','page_id');		

	}

	public function Comment(){

		return $this->hasMany('App\Models\Comment','post_id','id')->orderBy('comments.created_at','ASC');		

	}

}
