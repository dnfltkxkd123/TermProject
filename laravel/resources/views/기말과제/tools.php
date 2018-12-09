<?php
	function requestValue($name){
		return isset($_REQUEST[$name])?$_REQUEST[$name]:'';
	}

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
				location.href = '<?=$url?>';
			</script>
		</body>
		</html>
		<?php
		exit();
	}


	function loginOk(){
		?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<title>Document</title>
		</head>
		<body>
			<script>
				//history.go(-2);
				history.back();
			</script>
		</body>
		</html>
		<?php
		exit();
	}

	function logOut(){
		?>
		<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<title>Document</title>
		</head>
		<body>
			<script>
				history.back();
			</script>
		</body>
		</html>
		<?php
		exit();
	}



	function bdUrl($file,$num,$page){
		$join = "?";
		if($num){
			$file .= $join."num=".$num;
			$join = "&";
		}
		if($page){
			$file .=$join."page=".$page;
		}
		return $file;
		exit();
	}

	function sessionVar($name){
		return isset($_SESSION[$name])?$_SESSION[$name]:"";
	}

	function loginCheck(/*$url*/){
		session_start();
		$sessionOk = isset($_SESSION['id'])?true:false;
		if(!$sessionOk){
		    ?>
		    <!DOCTYPE html>
		    <html lang="en">
		    <head>
		      <meta charset="UTF-8">
		      <title>Document</title>
		    </head>
		    <body>
		      <script>
		        location.href='main_page.php';
		        //history.back();
		      </script>
		    </body>
		    </html>
		    <?php
		  }
	}

	function logoutBack($url){
		//session_start();
		$sessionOk = isset($_SESSION['id'])?true:false;
		if(!$sessionOk){
		    ?>
		    <!DOCTYPE html>
		    <html lang="en">
		    <head>
		      <meta charset="UTF-8">
		      <title>Document</title>
		    </head>
		    <body>
		      <script>
		       location.href='<?=$url?>';
		       //history.back();
		      </script>
		    </body>
		    </html>
		    <?php
		  }
	}

	function logoutBack2(){
		//session_start();
		$sessionOk = isset($_SESSION['id'])?true:false;
		if(!$sessionOk){
		    ?>
		    <!DOCTYPE html>
		    <html lang="en">
		    <head>
		      <meta charset="UTF-8">
		      <title>Document</title>
		    </head>
		    <body>
		      <script>
		      
		       history.back();
		      </script>
		    </body>
		    </html>
		    <?php
		  }
	}

	function loginBack(){
		$sessionOk = isset($_SESSION['id'])?true:false;
		if($sessionOk){
		    ?>
		    <!DOCTYPE html>
		    <html lang="en">
		    <head>
		      <meta charset="UTF-8">
		      <title>Document</title>
		    </head>
		    <body>
		      <script>
		        history.back();
		      </script>
		    </body>
		    </html>
		    <?php
		  }
	}

	function logoutBackMain(){
		//session_start();
		$sessionOk = isset($_SESSION['id'])?true:false;
		if($sessionOk){
		    ?>
		    <!DOCTYPE html>
		    <html lang="en">
		    <head>
		      <meta charset="UTF-8">
		      <title>Document</title>
		    </head>
		    <body>
		      <script>
		        location.href='main_page.php';
		      </script>
		    </body>
		    </html>
		    <?php
		  }
	}

	/*
	function getUrl(){
		return $_SERVER["HTTP_HOST"].$_SERVER["PHP_SELF"].'?'.getenv("QUERY_STRING");
	}
	*/

?>