<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $table = 'member';
    public $timestamps = false;
    
    public function scopeGetMember($query,$id){
        $data = $query->where('id','=',$id)->get();

    	return $data;
    }

    public function scopeGetNMember($query,$nickname){
        return $query->where('nickname','=',$nickname)->get();
    }

    public function scopeRegisterMember($query,$id,$name,$nickname,$email,$pw,$img){
    	$data = [
    		'id' => $id,
    		'name' => $name,
    		'email' => $email,
    		'nickname' => $nickname,
    		'pw' => $pw,
    		'img' => $img
    	];
    	$query -> insert($data);
    }

    public function scopeMemberUpdate($query,$id,$name,$nickname,$email,$pw,$img){
        $data = [
            'name' => $name,
            'email' => $email,
            'nickname' => $nickname,
            'pw' => $pw,
            'img' => $img
        ];
        $query ->where('id','=',$id)->update($data);
    }
    
}
