<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Donate;
use App\RecommendComment;

class DonateController extends Controller
{
    //
    public function insertData(Request $request){
    	
    	session_start();
		require('tool.php');
		$nickname = sessionVar('nickname');
		$id = sessionVar('id');
		$page = $request-> input('page');
		$title = $request->input('title');
		$thema = $request->input('thema');
		$content = $request->input('content');
		$content = nl2br($content);
		if($nickname &&$title && $thema && $content){
			
			if($request->hasFile('file')){
				
				$img = $request->file('file')->getClientOriginalName();
				$img = $id.'_recommend_'.$img;
				if(file_exists('images/'.$img)){
					$img ='p'.$img;
				}
				
				$tmp = 'images/'.$img;
				?>
				
				<script type="text/javascript">
					//alert('<?=$img ?>');
				</script>
				<?php
				$request -> file('file') -> move('images',$img);
				Donate::insertData($nickname,$title,$tmp,$thema,$content);
			}else{
				
				$img = 'http://placehold.it/148x210';

				Donate::insertData($nickname,$title,$img,$thema,$content);
				
			}
			
			okGo('등록완료!','donateBook?thema='.$thema.'&page='.$page);
			
		}else{
			?>
			<script type="text/javascript">
				alert('빈칸을 모두 넣어 주세요');
			</script>
			<?php
			
		}
		
    }

    public function updateData(Request $request){
    	session_start();
		require('tool.php');
		$nickname = sessionVar('nickname');
		$id = sessionVar('id');
		$page = $request-> input('page');
		$title = $request->input('title');
		$num = $request-> input('num');
		$thema = $request->input('thema');
		$content = $request->input('content');
		$content = nl2br($content);
		if($nickname &&$title && $thema && $content){
			
			if($request->hasFile('file')){
				
				$img = $request->file('file')->getClientOriginalName();
				$img = $id.'_recommend_update_'.$num.'_'.$img;
				if(file_exists('images/'.$img)){
					$img ='p'.$img;
				}
				
				$tmp = 'images/'.$img;
				?>
				
				<script type="text/javascript">
					//alert('<?=$img ?>');
				</script>
				<?php
				$request -> file('file') -> move('images',$img);
				Donate::updateData($num,$title,$tmp,$thema,$content);
			}else{
				$data = Donate::getData($num);
				$img = $data[0]->img;

				Donate::updateData($num,$title,$img,$thema,$content);
				
			}
			
			okGo('등록완료!','donate_book_info?num='.$num.'&page='.$page);
			
		}else{
			?>
			<script type="text/javascript">
				alert('빈칸을 모두 넣어 주세요');
			</script>
			<?php
			
		}
    }

    public function deleteData(Request $request){
    	$num = $request-> input('num');
    	$thema = $request-> input('thema');
    	Donate::deleteData($num);
    	?>
				
				<script type="text/javascript">
					alert('삭제완료');
					location.href = 'donateBook?thema=<?=$thema?>';
				</script>
				<?php
    }


    public function donatePagenation(Request $request){
    	
    	define('ONE_PAGE_LIST',10);
    	define('PAGE_LINK',5);
    	$count = Donate::count();
    	$page = $request->page;
    	if($count>=0){
    		$pageCount = ceil($count/ONE_PAGE_LIST);
    		if($page>$pageCount){
    			$page = $pageCount;
    		}
    		if($page<1){
    			$page = 1;
    		}

    		$start = ($page-1)*ONE_PAGE_LIST;
    		$getOnePageList = Donate::orderBy('date','desc')->skip($start)->take(ONE_PAGE_LIST)->get();

    		$firstLink = floor(($page-1)/PAGE_LINK)*PAGE_LINK+1;
    		$lastLink = $firstLink+PAGE_LINK-1;
    		if($lastLink>$pageCount){
    			$lastLink = $pageCount;
    		}
    	}
    	return view('기말과제.donate_book')->with('getOnePageList',$getOnePageList)
    										->with('page',$page)
    										->with('firstLink',$firstLink)
    										->with('lastLink',$lastLink)
    										->with('page',$page)
                                            ->with('pageCount',$pageCount);
    }


    public function salePagenation(Request $request){
        
        define('ONE_PAGE_LIST',10);
        define('PAGE_LINK',5);
        $seller = $request -> seller;
        $count = Donate::where('nickname','=',$seller)->get()->count();
        $page = $request->page;
        if($count>=0){
            $pageCount = ceil($count/ONE_PAGE_LIST);
            
            if($page>$pageCount){
                $page = $pageCount;
            }
            if($page<1){
                $page = 1;
            }

            $start = ($page-1)*ONE_PAGE_LIST;
            $getOnePageList = Donate::where('nickname','=',$seller)->where('sale_status','=','sale')->orderBy('num','desc')->skip($start)->take(ONE_PAGE_LIST)->get();
            $firstLink = floor(($page-1)/PAGE_LINK)*PAGE_LINK+1;
            $lastLink = $firstLink+PAGE_LINK-1;
            if($lastLink>$pageCount){
                $lastLink = $pageCount;
            }
        }
        return view('기말과제.my_sale_book')->with('getOnePageList',$getOnePageList)
                                            ->with('page',$page)
                                            ->with('firstLink',$firstLink)
                                            ->with('lastLink',$lastLink)
                                            ->with('page',$page)
                                            ->with('pageCount',$pageCount);
    }

    public function donateInfo(Request $request){
    	$num = $request -> num;
    	$datas = Donate::where('num','=',$num)->orderBy('date','desc')->take(1)->get();


    	return view('기말과제.donate_book_info')->with('datas',$datas);
    }

    public function order(Request $request){
    	$num = $request -> num;
    }
}
