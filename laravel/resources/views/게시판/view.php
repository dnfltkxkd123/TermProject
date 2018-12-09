<?php
	require('tools.php');
	require("BoardDao.php");

	//전달된 값 저장
	$num = requestValue("num");
	$page = requestValue("page");

	//지정된 번호의 글 데이터를 읽고, 조회수 증가
	$dao = new BoardDao();
	$row = $dao -> getData($num);
	$dao -> increaseHits($num);

	//제목의 공백, 본문의 공백과 줄넘김이 웹에서 보이도록 처리 
	//str_replace("찾을문자열","치환할문자열","대상문자열");
	$row["title"] = str_replace("", "&nbsp;", $row["title"]);
	$row["content"] = str_replace("", "&nbsp;", $row["content"]);
	$row["content"] = str_replace("\n", "<br>", $row["content"]);
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
		<table class="msg">
			<tr>
				<th class="msg-header">제목</th>
				<td class="msg-text left"><?=$row["title"];?></td>
			</tr>
			<tr>
				<th>작성자</th>
				<td class="msg-text left"><?=$row["writer"];?></td>
			</tr>
			<tr>
				<th>작성일시</th>
				<td class="msg-text left"><?=$row["regtime"];?></td>
			</tr>
			<tr>
				<th>조회수</th>
				<td class="msg-text left"><?=$row["hits"];?></td>
			</tr>
			<tr>
				<th>내용</th>
				<td class="msg-text left"><?=$row["content"];?></td>
			</tr>
		</table>
		<div class="left">
			<input type="button" onclick="location.href='<?=bdUrl("board.php",0,$page);?>'" value='목록보기'>
			<input type="button" value="수정" onclick="location.href='<?=bdUrl("modify_form.php",$num,$page);?>'">
			<input type="button" value="삭제" onclick="location.href='<?=bdUrl("delete.php",$num,$page)?>' ">
		</div>
	</div>
	
</body>
</html>