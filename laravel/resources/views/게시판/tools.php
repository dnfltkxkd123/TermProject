<?php
	//게시판 모듈의 URL을 반환하는 함수
	function bdUrl($file,$num,$page){
		$join = "?";
		if($num){
			$file .= $join."num=$num";
			$join = "&";
		}
		if($page){
			$file .=$join."page=$page";
		}
		return $file;
	}

	//세션이 시작되지 않았으면 시작하는 함수
	function session_start_if_none(){
		if(session_status() == PHP_SESSION_NONE)
			session_start();
	}

	function requestValue($name){
		return isset($_REQUEST[$name])?$_REQUEST[$name]:"";
	}


	//세션변수 값을 읽어 반환하는 함수
	//해당값의 정의되지 않았으면 빈 문자열을 반환
	function sessionVar($name){
		return isset($_SESSION[$name])?$_SESSION[$name]:"";
	}

	//경고창에 오류 세시지를 출력하고 이전 페이지로 돌아가는 함수
	function errorBack($msg){
		?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<title>Document</title>
		</head>
		<body>
			<script>
				alert('<?=$msg?>');
				history.back();
			</script>
		</body>
		</html>
		<?php
		exit();
	}

	//경고창에 지정된 메세지를 추력하고
	//지정된 페이지로 돌아가는 함수
	function okGo($msg,$url){
		?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<title>Document</title>
		</head>
		<body>
			<script>
				alert('<?=$msg?>');
				location.href="<?=$url?>";
			</script>
		</body>
		</html>
		<?php
		exit();
	}
?>