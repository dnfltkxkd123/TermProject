<?php
	require("tools.php");
	require("BoardDao.php");

	//전달된 페이지 번호 저장
	$nowPage = requestValue("page");

	//화면구성에 관렫뇌 상수 정의
	define("LIST_COUNT",5);//게시글 리스트의 줄수
	define("PAGE_COUNT",3);//화면에 표시될 페이지 링크의 수

	//게시판의 전체 게시글 수 구하기
	$dao = new BoardDao();
	$listCount = $dao->getDataCount();

	if($listCount >= 0){
		//전체 페이지수 구하기
		$pageSum = ceil($listCount/LIST_COUNT);//ceil()는 소수점 이하를 무조건 올린다.

		//현제 페이지 번호가(1~ 전체 페이지수)를 벗어나면 보정
		if($nowPage<1)
			$nowPage = 1;
		if($nowPage > $pageSum)
			$nowPage = $pageSum;

		//리스트에 보일게시글 데이터 읽기
		$start = ($nowPage-1)*LIST_COUNT; // 첫줄의 레코드 번호
		$onePageData = $dao->getOnePageList($start,LIST_COUNT);
	}

	//페이지네이션 컨트롤의 처음/마지막 페이지 링크 번호 계산
	$firstLink = floor(($nowPage-1)/PAGE_COUNT)*PAGE_COUNT+1;
	$lastLink = $firstLink + PAGE_COUNT - 1;
	if($lastLink>$pageSum)
		$lastLink = $pageSum;
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
	<?php if($listCount >0):?>
		<table class="list">
			<tr>
				<th class="List-num">번호</th>
				<th class="List-title">제목</th>
				<th class="List-writer">작성자</th>
				<th class="List-regtime">작성일시</th>
				<th>조회수</th>
			</tr>

			<?php foreach($onePageData as $row):?>
				<tr>
					<td><a href="<?= bdUrl("view.php",$row['num'],$nowPage) ?>"><?=$row['num']?></a></td>
					<td><?=$row['title']?></td>
					<td><?=$row['writer']?></td>
					<td><?=$row['regtime']?></td>
					<td><?=$row['hits']?></td>
				</tr>
			<?php endforeach ?>
		</table>

		<br>
		<?php if($firstLink >1 ): ?>
			<a href="<?= bdUrl('게시판',0,$nowPage-PAGE_COUNT)?>"><</a>&nbsp;
	<?php endif ?>

			<?php for($i= $firstLink; $i <= $lastLink; $i++): ?>
				<?php if ($i == $nowPage):?>
					<a href="<?= bdUrl("게시판",0,$i)?>"><b><?= $i ?></b></a>&nbsp;

				<?php else : ?>
					<a href="<?=bdUrl("게시판",0,$i)?>"><?= $i ?></a>&nbsp;

				<?php endif ?>
			<?php endfor?>

			<?php if($lastLink < $pageSum): ?>
				<a href="<?= bdUrl("게시판",0,$nowPage + PAGE_COUNT)?>">></a>
			<?php endif?>

		<?php endif?>

	

	<br><br>
	<div class="right">
		<input type="button" value="글쓰기" onclick="location.href='<?= bdUrl("view",0,$nowPage)?>'">
	</div>
	
	</div>
	<?php echo date("Y-m-d H:i:s")?>
</body>
</html>
