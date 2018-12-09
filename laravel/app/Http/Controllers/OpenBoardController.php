<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OpenBoard;
class OpenBoardController extends Controller
{
    //
    public function insertData(){
    	session_start();
		require('tool.php');
		$nickname = $_SESSION['nickname'];
		$title = requestValue('title');
		$text = requestValue('text');
		$currnetPage = requestValue('page');
		OpenBoard::insertData($title,$nickname,$text);
		okGo('작성한 글이 성공적으로 등록 됬습니다.','openBoard?page='.$currnetPage);
    }

    public function updateData(){
    	session_start();
		require('tool.php');
		$title = requestValue('title');
		$nickname = $_SESSION['nickname'];
		$text = requestValue('text');
		$num = requestValue('num');
		$currentPage = requestValue('page');
		OpenBoard::updateData($num,$title,$text);
		okGo('작성한 글이 성공적으로 등록 됬습니다.','openBoard_page?page='.$currentPage.'&num='.$num);
    }

    public function deleteData(){
    	require('tool.php');
		$num = requestValue('num');
		OpenBoard::deleteData($num);
		okGo('작성한 글이 성공적으로 삭제 되었습니다.','openBoard?page=1');
	 }


	public function pagenation(Request $request){
    	$select = $request -> input('select');
    	$text = $request -> input('text');
    	$page = $request -> input('page');
    	define('ONE_PAGE_LIST',5);
    	define('PAGE_LINK',5);
    	$countSum = OpenBoard::where($select,'like','%'.$text.'%')->get()->count();
    	if($countSum>=0){
    		$pageCount = ceil($countSum/ONE_PAGE_LIST);
    		if($page > $pageCount){
    			 $page = $pageCount;
    		}
    		if($page<1){
    			$page=1;
    		}

    		$start = ($page-1)*ONE_PAGE_LIST;
    		$onePageList = OpenBoard::where($select,'like','%'.$text.'%')->orderby('date','desc')->skip($start)->take(ONE_PAGE_LIST)->get();

    		$firstLink = floor(($page-1)/PAGE_LINK)*PAGE_LINK+1;
            $lastLink = $firstLink+PAGE_LINK-1;
            if($lastLink>$pageCount){
                $lastLink = $pageCount;
            }
        }
        return view('기말과제.openBoard2')->with('onePageList',$onePageList)
                                            ->with('page',$page)
                                            ->with('firstLink',$firstLink)
                                            ->with('lastLink',$lastLink)
                                            ->with('page',$page)
                                            ->with('select',$select)
                                            ->with('text',$text)
                                            ->with('pageCount',$pageCount);
    }
}
