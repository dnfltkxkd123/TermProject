<?php
	require('tools.php');
	require('replyCommentDao.php');
	$table = requestValue('table');
	$count = requestValue('count');
	$text = requestValue('text');
	$text = nl2br($text);
	$nickname = requestValue('nickname');
	$dao = new replyCommentDao($table);
	$dao -> insertReply($count,$text,$nickname);
	loginOk();
?>