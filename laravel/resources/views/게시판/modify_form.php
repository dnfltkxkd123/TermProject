<?php
	require("tools.php");
	require("BoardDao.php");
	$num = requestValue("num");
	$page = requestValue("page");
	$dao = new BoardDao();
	$data = $dao -> getData($num);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="board.css"/>
</head>
<body>
	<div class="container">
		<form action="<?=bdUrl('modify.php',$num,$page)?>" method="post">
			<table class="msg">
				<tr>
					<th>제목</th>
					<td><input type="text" name="title" maxlength="80" class="msg-text" value="<?=$data['title']?>"></td>
				</tr>
				<tr>
					<th>작성자</th>
					<td><input type="text" name="writer" maxlength="20" class="msg-text" value="<?=$data['writer']?>"></td>
				</tr>
				<tr>
					<th>내용</th>
					<td><textarea type="text" name="content" wrap="virtual" rows="10" class="msg-text"><?=$data['content']?></textarea></td>
				</tr>
			</table>
				<br>
				<div class="left">
					<input type="submit" value="적용">
					<input type="button" onclick="location.href='<?=bdUrl("board.php",0,$page);?>'" value='목록보기'>
				</div>
		</form>
	</div>
</body>
</html>