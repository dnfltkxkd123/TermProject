<?php
	session_start();
	require('tools.php');
	require('openBoardDao.php');
	$title = requestValue('title');
	$nickname = $_SESSION['nickname'];
	$text = requestValue('text');
	$num = requestValue('num');
	$currentPage = requestValue('page');
	$dao = new OpenBoardDao();
	$dao -> updateData($num,$title,$text);
	okGo('작성한 글이 성공적으로 등록 됬습니다.','openBoard_page.php?page='.$currentPage.'&num='.$num);
?>