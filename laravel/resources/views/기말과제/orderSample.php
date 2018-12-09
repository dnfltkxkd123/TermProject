<?php
  session_start();
  require('tools.php');
  require('memberDao.php');
  $sessionOk = sessionVar('id');
  $mdao = new MemberDao();
  if($sessionOk){
    $member = $mdao -> getMember($sessionOk);
    $img = $member['img'];
    if($img == null){
      $img = "http://www.tangoflooring.ca/wp-content/uploads/2015/07/user-avatar-placeholder.png";
    }
  }else{
    ?>
      <script type="text/javascript">
        location.href = "donateBook";
      </script>
    <?php
  }
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
	<script src="/resources/js/addressapi.js"></script>
	<title>Document</title>
	<style>
        #tel{
            text-align: center;
        }
        .text{
            width:150px;
            display: inline-block;
        }
        .box{
            border:solid #e9e9e9;
            padding:20px;
            width:600px;
            margin:100px auto;
        }
        .info{
        	border-bottom: dotted #e9e9e9;
        }
    </style>
</head>
<body>
	<?php require('navigationbar3.php');
	$num = requestValue('num');
  $title = requestValue('title');
  $img = requestValue('img');
  $thema = requestValue('thema');
  $content = requestValue('content');
  $nickname = requestValue('nickname');
  $title = requestValue('title');
  $seller = $mdao -> getNickname($nickname);
	?>
	<?=$seller['id']?>
	<div class='box'>
		<div class='info'>
			<img src="<?=$img?>" width='148px' height='210px' class="editor-icon"/>
			<p><a href='donate_book_info?page=<?=$currentPage?>&num=<?=$num?>&thema=<?=$thema?>'><?=$content?></a></p>
		</div>
		<div>
			<br>
			
		</div>
		
		<form action='order' method='get' enctype="multiple/part">
			<span class='text'>수령인</span><input type="text" id="" name='name' placeholder="수령인"><br><br>
	        <span class='text'>주소</span><input type="text" id="sample6_postcode" name='post' placeholder="우편번호" readonly onclick='sample6_execDaumPostcode()'>
	        <input type='hidden' value='<?=$sessionOk?>' name='buyer'>
	        <input type='hidden' value='<?=$seller['id']?>' name='seller'>
	        <input type='hidden' value='<?=$num?>' name='num'>
	        <input type='hidden' value='<?=$title?>' name='title'>
	        <input type='hidden' value='<?=$img?>' name='img'>
	        <input type="button" onclick="sample6_execDaumPostcode()"  value="우편번호 찾기"><br><br>
	        <span class='text'></span><input type="text" id="sample6_address" name='addr1' placeholder="주소"  size=40><br><br>
	        <span class='text'></span><input type="text" id="sample6_address2" name='addr2' placeholder="상세주소"  size=40><br><br>
	        <span class='text'>휴대폰번호</span><input type="text" id="tel" name='phone1' placeholder="" size=2>-<input type="text" id="tel" name='phone2' placeholder="" size=2>-<input type="text" id="tel" name='phone3' placeholder="" size=2><br><br>
	        <span class='text'>전화번호</span><input type="text" id="tel" name='tel1' placeholder="" size=2>-<input type="text" id="tel" name='tel2' placeholder="" size=2>-<input type="text" id="tel" name='tel3' placeholder="" size=2><br><br>
	        <input type='submit' class='btn primary' value='완료'>
		</form>
    </div>
    
	<script>
	    function sample6_execDaumPostcode() {
	        new daum.Postcode({
	            oncomplete: function(data) {
	                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

	                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
	                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
	                var fullAddr = ''; // 최종 주소 변수
	                var extraAddr = ''; // 조합형 주소 변수

	                // 사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
	                if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
	                    fullAddr = data.roadAddress;

	                } else { // 사용자가 지번 주소를 선택했을 경우(J)
	                    fullAddr = data.jibunAddress;
	                }

	                // 사용자가 선택한 주소가 도로명 타입일때 조합한다.
	                if(data.userSelectedType === 'R'){
	                    //법정동명이 있을 경우 추가한다.
	                    if(data.bname !== ''){
	                        extraAddr += data.bname;
	                    }
	                    // 건물명이 있을 경우 추가한다.
	                    if(data.buildingName !== ''){
	                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
	                    }
	                    // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
	                    fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
	                }

	                // 우편번호와 주소 정보를 해당 필드에 넣는다.
	                document.getElementById('sample6_postcode').value = data.zonecode; //5자리 새우편번호 사용
	                document.getElementById('sample6_address').value = fullAddr;

	                // 커서를 상세주소 필드로 이동한다.
	                document.getElementById('sample6_address2').focus();
	            }
	        }).open();
	    }
	</script>
</body>
</html>