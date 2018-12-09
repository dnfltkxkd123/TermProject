<?php
	require("tools.php");
	require("BoardDao.php");
	$page = requestValue("page");
	$num = requestValue("num");
	$dao = new BoardDao();
	$dao -> deleteData($num);
	okGo("삭제되었습니다.",bdUrl("board.php",0,$page));
?>