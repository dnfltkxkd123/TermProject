<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BBSController extends Controller
{
    //

    public function login(){
    	require('tools.php');
		require('memberDao.php');
		$id = requestValue('id');
		$pw = requestValue('pw');
		$url = requestValue('url');
		$num = requestValue('num');
		$page = requestValue('page');
		$mdao = new MemberDao();
		$member = $mdao -> getMember($id);

		if($id && $pw){
			if($member && $member['id']){
				if($member['pw'] == $pw){
					session_start();
					$_SESSION['id'] = $id;
					$_SESSION['nickname'] = $member['nickname'];
					okGo('로그인 성공',bdUrl($url,$num,$page));
					exit();
					//loginOk();
				}else{
					errorBack('아이디 또는 비밀번호가 같지 않습니다.');
				}
			}else{
				errorBack('아이디 또는 비밀번호가 같지 않습니다.');
			}
		}else{
			errorBack('빈칸을 모두 입력하세요!!');
		}
	    }
}
