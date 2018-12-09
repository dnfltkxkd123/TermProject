<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OpenBoard extends Model
{
    //
    protected $table = 'openboard';
    public $timestamps = false;

    public function scopeInsertData($query,$title,$nickname,$text){
    	
    	$data = [
    		'title' => $title,
    		'nickname' => $nickname,
    		'text' => $text,
    		'date' => now()
    	];
    	
    	$query->insert($data);
    }

    public function scopeDeleteData($query,$num){
    	$query -> where('num','=',$num)->delete();
    }

    public function scopeUpdateData($query,$num,$title,$text){
    	$data = [
    		'title' => $title,
    		'text' => $text
    	];
    	$query->where('num','=',$num)->update($data);
    }

   


}
