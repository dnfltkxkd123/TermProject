<?php
	require_once('recommend_bookSample.php');
	foreach($datas as $data){
		$num = $data['num'];
		$title = $data['title'];
		$content = $data['content'];
		$img = $data['img'];
		$thema = $data['thema'];
		$nickname = $data['nickname'];
	}
	$loginOk = isset($_SESSION['id']);
	$nicknameCheck = isset($_SESSION['nickname'])?$_SESSION['nickname']:'';
?>

<script>
	<?php if($data['sale_status']=='sale'):?>
		var r = $("<button type='button' class='btn btn-success btn-product' id='button' title='Edit' onclick='check2(<?=$loginOk?>)'><span class='glyphicon glyphicon-shopping-cart'>책받기</span></button>")
	<?php endif ?>

	<?php if($data['sale_status']=='sold_out'):?>
		var r = $("<span class='btn glyphicon btn-product btn-success'>품절</span>");
    <?php endif ?>

	function check2(check){
		var seller = '<?=$nickname?>';
		var buyer = '<?=$nicknameCheck?>';
		if(seller == buyer){
			alert('제공자와 구매자의 정보가 같습니다.');
			return;
		}
		if(check){
			location.href="orderSample?num=<?=$num?>&title=<?=$title?>&content=<?=$content?>&img=<?=$img?>&thema=<?=$thema?>&nickname=<?=$nickname?>";
		}else{
			alert('로그인 해주세요!!');
		}
	}
	//
	$('#commentForm').append(r);
</script>