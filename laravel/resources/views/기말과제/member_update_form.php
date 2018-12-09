<?php
  $url='main_page';
  //require('navigationbar3.php');
  
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
  }
  
  $id = requestValue('id');
  $name = requestValue('name');
  $nickname = requestValue('nickname');
  $email = requestValue('email');
  $pw = requestValue('pw');
  $member = $mdao -> getMember($sessionOk);
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
        location.href='bookCommunityMain';
      </script>
    </body>
    </html>
    <?php
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel='stylesheet' href='css/post.css'>
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="js/ajax2.js"></script>
  <script type="text/javascript" src="js/drag_and_drop.js"></script>
</head>
<body onload="">
<div id='test'></div>
<?php
  require('navigationbar3.php');
?>
  <div class="container">
    <h1>회원정보 수정</h1>
    <hr>
  <div class="row">
      <!-- left column -->
      <form action='memberUpdate' role="form" method='post' enctype='multipart/form-data' id='form'>
      <div class="col-md-3" id='dropZone'>
        <div class="text-center">
          <img src="//placehold.it/100" id='book' class="img-circle" alt="avatar" width='100px' height='100px'>
          <h6>이미지를 드래그 해주세요</h6>
          <input type="hidden" name="_token" value="<?= csrf_token() ?>">
          <input type="file" class="form-control" id='file' onchange='loadFile(event)' name='file' accept='image/*'>
        </div>
      </div>
      
        
      <div class="col-md-9 personal-info" role="form">
        <div class="alert alert-info alert-dismissable">
          <a class="panel-close close" data-dismiss="alert">×</a> 
          <i class="fa fa-coffee"></i>
          이미지는 추가 안해도 됩니다.
        </div>
        <h3>회원정보</h3>
        
        <div class="form-horizontal" role="form">
          <div class="form-group">
            <label class="col-lg-3 control-label">이름:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" name='name' value='<?=$member['name']?>'>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">ID:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" name="id" value='<?=$member['id']?>' readonly>
            </div>
          </div>
            <div class="form-group">
            <label class="col-lg-3 control-label">닉네임:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" name="nickname" value='<?=$member['nickname']?>'>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">Email:</label>
            <div class="col-lg-8">
              <input class="form-control" type="text" name="email" value='<?=$member['email']?>' >
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">비밀번호:</label>
            <div class="col-lg-8">
              <input class="form-control" type="password" name="pw">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label">비밀번호 확인:</label>
            <div class="col-lg-8">
              <input class="form-control" type="password" name="pw_confirm">
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-3 control-label"></label>
            <div class="col-lg-3">
              <input type="button" class="btn btn-primary" value="저장" onclick="fileCheck('#test','memberUpdate')">
              <span></span>
              <input type="reset" class="btn btn-default" value='초기화'>
            </div>
          </div>
        </div>
      </div>
      <hr>
    </form>
  </div>
</div>



</body>
</html>