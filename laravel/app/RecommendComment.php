<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecommendComment extends Model
{
    protected $table = 'recommend_comment';
    public $timestamps = false;

    public function scopeInsertComment($query,$num,$nickname,$text){
    	$date = [
    		'num'=>$num,
    		'nickname'=>$nickname,
    		'text'=>$text,
    		'date'=>now()
    	];
    	$query->insert($date);
    }

    public function scopeUpdateComment($query,$count,$text){
    	$date = [
    		'text'=>$text
    	];
    	$query -> where('count','=',$count)->update($date);
    }

    public function scopeDeleteComment($query,$count){
    	$query -> where('count','=',$count)->delete();
    }
}
