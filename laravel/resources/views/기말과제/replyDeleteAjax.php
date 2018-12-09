<?php
	require('tools.php');
	require('replyCommentDao.php');
	$table = requestValue('table');
	$num = requestValue('num');
	//$nickname = requestValue('nickname');
	$dao = new replyCommentDao($table);
	$dao -> deleteReply($num);
?>
<script type="text/javascript">
	//alert('<?=$table?>/<?=$num?>');
</script>