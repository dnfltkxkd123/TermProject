<?php
  $url = 'donate_book.php';
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
  $loginOk = isset($_SESSION['id']);
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
  <link rel='stylesheet' href='css/recommend4.css'>
  <script type="text/javascript" src="js/ajax.js"></script>
  <script>
      function loginCheck(check){
        if(check){
            location.href='post_form.php';
        }else{
            alert('로그인 해주세요!!');
        }
      }
  </script>
</head>
<body onload="request('navi','navigationbar.php')">
<!--<div id='navi'></div>-->
<?php
  require('navigationbar3.php');
?>

  <div class="contents">
       <h1>구현준비중</h1>
        <button id="myShowHidebtn" class="btn btn-primary" onclick="loginCheck(<?=$loginOk?>)" style='position:fixed;float:right;margin-right:10px;'>책기부하기</button>
       <div class="l-wrapper">
        <ul class="l-row">
            <li class="l-col" style='cursor:pointer;'>
                <div class="editor brackets">
                    <img class="editor-icon" src="test.png" width='100%'>
                    <p>돌이킬 수 없는 약속</p>
                    <select>
                      <option>택배선택1</option>
                      <option>택배선택2</option>
                      <option>택배선택3</option>
                    </select>
                    <input type='text' placeholder="운송번호"><br><br>
                    <button type="button" class="btn btn-success btn-product" title="Edit" onclick="">등록</button>
                    <br>
                    <br>
                </div> 
            </li>
            <li class="l-col" style='cursor:pointer;'>
                <div class="editor brackets">
                    <img class="editor-icon" src="test.png" width='100%'>
                    <p>돌이킬 수 없는 약속</p>
                    <button type="button" class="btn btn-success btn-product" title="Edit" onclick=""><span class='glyphicon glyphicon-shopping-cart'>책받기</span></button>
                    <br>
                    <br>
                </div> 
            </li>
            <li class="l-col" style='cursor:pointer;'>
                <div class="editor brackets">
                    <img class="editor-icon" src="test.png" width='100%'>
                    <p>돌이킬 수 없는 약속</p>
                    <button type="button" class="btn btn-success btn-product" title="Edit" onclick=""><span class='glyphicon glyphicon-shopping-cart'>책받기</span></button>
                    <br>
                    <br>
                </div> 
            </li>
            <li class="l-col" style='cursor:pointer;'>
                <div class="editor brackets">
                    <img class="editor-icon" src="test.png" width='100%'>
                    <p>돌이킬 수 없는 약속</p>
                    <button type="button" class="btn btn-success btn-product" title="Edit" onclick=""><span class='glyphicon glyphicon-shopping-cart'>책받기</span></button>
                    <br>
                    <br>
                </div> 
            </li>
            <li class="l-col" style='cursor:pointer;'>
                <div class="editor brackets">
                    <img class="editor-icon" src="test.png" width='100%'>
                    <p>돌이킬 수 없는 약속</p>
                    <button type="button" class="btn btn-success btn-product" title="Edit" onclick=""><span class='glyphicon glyphicon-shopping-cart'>책받기</span></button>
                    <br>
                    <br>
                </div> 
            </li>
            <li class="l-col" style='cursor:pointer;'>
                <div class="editor brackets">
                    <img class="editor-icon" src="test.png" width='100%'>
                    <p>돌이킬 수 없는 약속</p>
                    <button type="button" class="btn btn-success btn-product" title="Edit" onclick=""><span class='glyphicon glyphicon-shopping-cart'>책받기</span></button>
                    <br>
                    <br>
                </div> 
            </li>
            <li class="l-col" style='cursor:pointer;'>
                <div class="editor brackets">
                    <img class="editor-icon" src="test.png" width='100%'>
                    <p>돌이킬 수 없는 약속</p>
                    <button type="button" class="btn btn-success btn-product" title="Edit" onclick=""><span class='glyphicon glyphicon-shopping-cart'>책받기</span></button>
                    <br>
                    <br>
                </div> 
            </li>
            <li class="l-col" style='cursor:pointer;'>
                <div class="editor brackets">
                    <img class="editor-icon" src="test.png" width='100%'>
                    <p>돌이킬 수 없는 약속</p>
                    <button type="button" class="btn btn-success btn-product" title="Edit" onclick=""><span class='glyphicon glyphicon-shopping-cart'>책받기</span></button>
                    <br>
                    <br>
                </div> 
            </li>
        </ul>
      </div>    
    </div>
  
</body>
</html>