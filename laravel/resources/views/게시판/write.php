<?php
	require("tools.php");
	require("BoardDao.php");

	//전달된 값 저장
	$writer = requestValue('writer');
	$title = requestValue('title');
	$content = requestValue('content');

	if($writer && $title && $content){
		$dao = new BoardDao();
		$dao -> insertData($writer,$title,$content);

		//글 목록으로 페이지로 복귀
		okGo("작성한 글이 등록됬습니다.",bdUrl("게시판",0,0));
	}else
		errorBack("모든 항목이 빈칸 없이 입력되여야 합니다.");
?>