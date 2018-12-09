<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
	//guarded
	protected $fillable = ['user_id','age','email','account'];
   	public $timestamps = false;
   	//public $timestamps = flase;

   	public function scopeDueInDays($query,$day){
   		return $query->where('date','>',\Carbon\Carbon::now()->subDays($day) );
   	}

   	public function setAccountAttribute($value){
        $this -> attributes['account'] = \Crypt::encrypt($value);
    }

   	public function getAccountAttribute($value){
        return \Crypt::decrypt($value);
    }

}
