<?php
	require('tools.php');
	require('commentDao.php');
	$table = requestValue('table');
	$dao = new CommentDao($table);
	$dao -> delete(requestValue('count'));
	loginOk();
?>