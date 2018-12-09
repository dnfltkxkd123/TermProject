<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donate extends Model
{
    //
    protected $table = 'donate_book';
    public $timestamps = false;

    public function scopeInsertData($query ,$nickname,$title,$img,$thema,$content){
    	$data = [
    		'nickname' => $nickname,
    		'title' => $title,
    		'img' => $img,
    		'thema' => $thema,
    		'content' => $content,
    		'date' => now()
    	];
    	$query -> insert($data);
    }

     public function scopeUpdateData($query ,$num,$title,$img,$thema,$content){
        $data = [
            'title' => $title,
            'img' => $img,
            'thema' => $thema,
            'content' => $content
        ];
        $query ->where('num','=',$num)-> update($data);
    }

    public function scopeGetData($query ,$num){
         $data = $query ->where('num','=',$num)->get();
         return $data;
    }

    public function scopeDeleteData($query ,$num){
        $query ->where('num','=',$num)-> delete($num);
    }
}
