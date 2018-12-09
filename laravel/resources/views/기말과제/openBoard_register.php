<?php
	session_start();
	require('tools.php');
	require('openBoardDao.php');
	$nickname = $_SESSION['nickname'];
	$title = requestValue('title');
	$text = requestValue('text');
	$currnetPage = requestValue('page');
	$dao = new OpenBoardDao();
	$dao -> insertData($title,$nickname,$text);
	okGo('작성한 글이 성공적으로 등록 됬습니다.','openBoard?page='.$currnetPage);
?>