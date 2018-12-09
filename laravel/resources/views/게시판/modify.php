<?php
	require("tools.php");
	require("BoardDao.php");
	$dao = new BoardDao();
	$title = requestValue("title");
	$writer = requestValue("writer");
	$content = requestValue("content");
	$page = requestValue("page");
	$num = requestValue("num");

	
	if($title && $writer && $content){
		$dao -> updateData($num,$title,$writer,$content);
		okGo("수정완료",bdUrl("board.php",0,$page));
	}else{
		errorBack("전부 입력해주세요!!");
	}
?>