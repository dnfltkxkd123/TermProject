<?php	

	session_start();
	require('tools.php');
	require('recommendDao.php');
	$nickname = sessionVar('nickname');
	$id = sessionVar('id');
	$page = requestValue('page');
	$title = requestValue('title');
	$thema = requestValue('thema');
	if(isset($_FILES['file']['name'])){
		$img = 'images/'.$id.'_'.'_recommend_'.$_FILES['file']['name'];
		$tmp_name = $_FILES['file']['tmp_name'];
	}else{
		$img = 'http://placehold.it/148x210';
		$tmp_name = null;
	}
	
	$content = requestValue('content');
	$content = nl2br($content);
	//echo $nickname.'<br>',$title.'<br>',$thema.'<br>',$img.'<br>',$content.'<br>';


	if($nickname &&$title && $thema &&$img && $content){
		$recommendDao = new RecommendDao();
		if(file_exists($img)){

		}else if(move_uploaded_file($tmp_name,$img)){
			$recommendDao -> insertData($nickname,$title,$img,$thema,$content);
		}else{
			//$img = 'http://placehold.it/148x210';
			$recommendDao -> insertData($nickname,$title,$img,$thema,$content);
		}
		okGo('등록완료!','recommendBoard?thema='.$thema.'&page='.$page);
	}else{
		errorBack('빈칸을 모두 넣어 주세요');
	}
	

?>