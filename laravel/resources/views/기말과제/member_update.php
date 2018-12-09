<?php

	require('tools.php');
	require('memberDao.php');
	
	$mdao = new MemberDao();
	$id = requestValue('id');
	$name = requestValue('name');
	$nickname = requestValue('nickname');
	$email = requestValue('email');
	$pw = requestValue('pw');
	$pw_confirm = requestValue('pw_confirm');
		

	if($name && $nickname && $email && $pw && $pw_confirm){
		$msg = '';
		$msgCount = 0;
		if($_FILES['file']['error'] == UPLOAD_ERR_OK){
			$fname = $id.'_update_'.$_FILES['file']['name'];
			$ftmp_name = $_FILES['file']['tmp_name'];
		}else{
			$fname = 'http://www.tangoflooring.ca/wp-content/uploads/2015/07/user-avatar-placeholder.png';
			$ftmp_name = false;
		}

		if(file_exists('images/'.$fname)){
			$fname ='1'.$fname;
		}

		if($nickname){
			$idOk = $mdao -> getNickname($nickname);
			if($idOk && $idOk['id'] ==$id && $idOk['nickname'] == $nickname){

			}else if($idOk && $idOk['nickname'] == $nickname){
				$msg .='같은 닉네임이 있습니다.\n';
				$msgCount++;
				?>
				<script>
					alert('같은 닉네임이 있습니다.');
				</script>
				<?php
				exit();
			}
		}

		if($pw != $pw_confirm){
			$msg .='비밀번호가 같지 않습니다.';
			$msgCount++;
			?>
				<script>
					alert('비밀번호가 같지 않습니다.');
				</script>
				<?php
				exit();
		}
		if($msgCount>0){
			//errorBack($msg);
		}

		if($ftmp_name && move_uploaded_file($ftmp_name,'images/'.$fname) ){
			$img = 'images/'.$fname;
			$mdao -> updateMember($id,$name,$nickname,$email,$pw,$img);
			session_start();
			$_SESSION['nickname'] = $nickname;
			unLink($idOk['img']);
			okGo('회원정보 수정 성공' , 'main_page.php');
		}else{
			$mdao -> updateMemberNoneImg($id,$name,$nickname,$email,$pw);
			session_start();
			$_SESSION['nickname'] = $nickname;
			okGo('회원정보 수정 성공' , 'main_page.php');
		}

	}else{
		//errorBack('빈칸을 모두 입력하세요!!');
		?>
				<script>
					alert('빈칸을 모두 입력하세요!!');
				</script>
				<?php
				exit();
	}
	
?>