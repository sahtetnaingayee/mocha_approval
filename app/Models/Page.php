<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //

    protected $table='pages';

    protected $fillable = array('page_id','name','caregory','access_token','status');


    public function Detail(){

		return $this->hasMany('App\Models\OrderDetail','parent_id');		
	}

}
