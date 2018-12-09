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
  }
  $form = requestValue('form');
  $id = sessionVar('nickname');
  $currnetPage = requestValue('page');
  $num = requestValue('num');
  $title = requestValue('title');
  $text = requestValue('text');
  $url = requestValue('url');
  if($form == 'insert'){
    $formText = '글작성';
    $url = 'openBoard_register';
    logoutBack(bdUrl('openBoard',$num,$currnetPage));
  }else if($form == 'update'){
    $formText = '글수정';
    $url = 'openBoard_update';
    logoutBack(bdUrl('openBoard_page',$num,$currnetPage));
  }
  logoutBack(bdUrl('openBoard',$num,$currnetPage));
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script type="text/javascript" src="nse_files/nse_files/js/HuskyEZCreator.js" charset="utf-8"></script>
  <style>
    .nse_content{width:720px;height:500px;}
    .contain{width:725px;margin:0 auto;}
   

  </style>
  <script type="text/javascript" src="js/ajax.js"></script>
  <script>
    
  </script>
</head>
<body onload="request('navi','navigationbar.php')">
<!--<div id='navi'></div>-->
<?php
  require('navigationbar3.php');
?>

  <div class='contain'>
    <h1><?=$formText?></h1>
    <form name="nse" action="<?=$url?>" >
    <div class="form-group">
        <label for="title">제목</label>
        <input type="text" class="form-control" name="title" value='<?=$title?>' />
    </div>
    
        <textarea name="text" id="ir1" class="nse_content" ></textarea>
        <script type="text/javascript">
          var oEditors = [];
          nhn.husky.EZCreator.createInIFrame({
              oAppRef: oEditors,
              elPlaceHolder: "ir1",
              sSkinURI: "nse_files/nse_files/SmartEditor2Skin.html",
              fCreator: "createSEditor2"
          });
          function submitContents(elClickedObj) {
              // 에디터의 내용이 textarea에 적용됩니다.
              oEditors.getById["ir1"].exec("UPDATE_CONTENTS_FIELD", []);
              // 에디터의 내용에 대한 값 검증은 이곳에서 document.getElementById("ir1").value를 이용해서 처리하면 됩니다.
   
              try {
                  elClickedObj.form.submit();
              } catch(e) {}
          }
          /*
          var textarea = $('.nse_content');
    
          textarea.css({width:'660px'});
          textarea.css({height:'500px'});
          textarea.css({display:'block'});
          textarea.css({margin:'0 auto'});
          */
        </script>
        <input type="hidden" class="form-control" name="num" value='<?=$num?>' />
        <input type="hidden" class="form-control" name="page" value='<?=$currnetPage?>' />
        <input class="btn btn-primary" type="submit" value="등록" onclick="submitContents(this)" />
        <input class="btn btn-default" type="button" value="취소" onclick="history.back()" />
    </form>
  </div>
  
    
</body>
</html>