<?php
	require("tools.php");

	//전달된 값 저장
	$page = requestValue("page");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="board.css">
</head>
<body>
	<div class="container">
		<form method="post" action="write.php">
			<table class="msg">
				<tr>
					<th>제목</th>
					<td><input type="text" name="title" maxlength="80" class="msg-text"></td>
				</tr>
				<tr>
					<th>작성자</th>
					<td><input type="text" name="writer" maxlength="20" class="msg-text"></td>
				</tr>
				<tr>
					<th>내용</th>
					<td><textarea type="text" name="content" wrap="virtual" rows="10" class="msg-text"></textarea></td>
				</tr>
			</table>
				<br>
				<div class="left">
					<input type="submit" value="글등록">
					<input type="button" onclick="location.href='<?=bdUrl("게시판",0,$page);?>'" value='목록보기'>
				</div>
		</form>
	</div>
</body>
</html>