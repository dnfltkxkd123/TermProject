<?php
	require('tools.php');
	require('replyCommentDao.php');
	$table = requestValue('table');
	$num = requestValue('num');
	$text = requestValue('text');
	$text = nl2br($text);
	$dao = new replyCommentDao($table);
	$dao -> updateReply($num,$text);
	loginOk();
?>