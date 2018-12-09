<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RecommendBoard;

class RecommendBoardController extends Controller
{
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
				RecommendBoard::insertData($nickname,$title,$tmp,$thema,$content);
			}else{
				
				$img = 'http://placehold.it/148x210';

				RecommendBoard::insertData($nickname,$title,$img,$thema,$content);
				
			}
			
			okGo('등록완료!','recommendBoard?thema='.$thema.'&page='.$page);
			
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
				RecommendBoard::updateData($num,$title,$tmp,$thema,$content);
			}else{
				$data = RecommendBoard::getData($num);
				$img = $data[0]->img;

				RecommendBoard::updateData($num,$title,$img,$thema,$content);
				
			}
			
			okGo('등록완료!','recommendBook?num='.$num.'&page='.$page);
			
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
    	RecommendBoard::deleteData($num);
    	?>
				
				<script type="text/javascript">
					alert('삭제완료');
					location.href = 'recommendBoard?thema=<?=$thema?>';
				</script>
				<?php
    }


    public function pagenation(Request $request){
    	$select = $request -> input('select');
    	$text = $request -> input('text');
    	$page = $request -> input('page');
    	$thema = $request -> input('thema');
    	define('ONE_PAGE_LIST',10);
    	define('PAGE_LINK',5);
    	$countSum = RecommendBoard::where($select,'like','%'.$text.'%')->where('thema',$thema)->get()->count();
    	if($countSum>=0){
    		$pageCount = ceil($countSum/ONE_PAGE_LIST);
    		if($page > $pageCount){
    			 $page = $pageCount;
    		}
    		if($page<1){
    			$page=1;
    		}

    		$start = ($page-1)*ONE_PAGE_LIST;
    		$onePageList = RecommendBoard::where($select,'like','%'.$text.'%')->where('thema',$thema)->orderby('date','desc')->skip($start)->take(ONE_PAGE_LIST)->get();

    		$firstLink = floor(($page-1)/PAGE_LINK)*PAGE_LINK+1;
            $lastLink = $firstLink+PAGE_LINK-1;
            if($lastLink>$pageCount){
                $lastLink = $pageCount;
            }
        }
        return view('기말과제.recommend_board2')->with('onePageList',$onePageList)
                                            ->with('page',$page)
                                            ->with('firstLink',$firstLink)
                                            ->with('lastLink',$lastLink)
                                            ->with('page',$page)
                                            ->with('select',$select)
                                            ->with('text',$text)
                                            ->with('thema',$text)
                                            ->with('pageCount',$pageCount);

    }
}
