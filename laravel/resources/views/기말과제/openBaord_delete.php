<?php
	require('tools.php');
	require('openBoardDao.php');
	$num = requestValue('num');
	$dao = new OpenBoardDao();
	$dao -> delete($num);
	okGo('작성한 글이 성공적으로 삭제 되었습니다.','openBoard.php?page=1');
?>