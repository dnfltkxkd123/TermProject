<?php
  $url='recommendBoard';
  require('tools.php');
  require('memberDao.php');
  require('recommendDao.php');
  $thema = requestValue('thema');
  
  session_start();
  $currentPage = requestValue('page');
  $sessionOk = sessionVar('id');
  if($sessionOk){
    $mdao = new MemberDao();
    $member = $mdao -> getMember($sessionOk);
    $img = $member['img'];
    if($img == null){
      $img = "http://www.tangoflooring.ca/wp-content/uploads/2015/07/user-avatar-placeholder.png";
    }
  }

  $loginOk = isset($_SESSION['id']);//sessionVar('id');


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
  <link rel='stylesheet' href='css/recommend2.css'>
  <script type="text/javascript" src="js/ajax.js"></script>
  <script>
      function loginCheck(check){
        if(check){
            location.href='recommend_form?page=<?=$currentPage?>&go=recommend_insert';
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
  <button id="myShowHidebtn" class="btn btn-primary" onclick="loginCheck(<?=$loginOk?>)" style='position:fixed;float:right;margin-right:10px;'>책추천 하기</button>
<div class="box">
        <h1 class='header'><?=$thema?> 추천</h1>

        <div class="wrap">
            <ul class="l-row">
                
                <?php foreach($onePageList as $row): ?>
                <li class="l-col">
                    <div class="editor">
                        <div class='thema'><span><?=$row['thema']?> 추천</span></div>
                        <img src="<?=$row['img']?>" width='148px' height='210px' class="editor-icon"/>
                        <div class='editor-text'>
                            <h2><a href='recommendBook?num=<?=$row['num']?>&thema=<?=$row['thema']?>'><?=$row['title']?></a></h2>
                            
                            <time><p>추천일:<?=$row['date']?></p></time>
                            <p>작성자:<?=$row['nickname']?></p>
                            <p><a href='recommendBook?num=<?=$row['num']?>'><?=$row['content']?></a></p>
                        </div>
                    </div>
                </li>
                <?php endforeach ?>
            </ul>
                    
        </div>

        <div style='width:100%;text-align: center;'>
                      <ul class="pagination">
                        <?php if($page>10): ?>
                          <li class="page-item"><a class="page-link" href='?page=<?=$page-5?>&thema=<?=$thema?>&select=<?=$select?>'><span class='btn btn-outline-dark slidebottomleft'><</span> </a></li>
                        <?php endif?>

                        <?php for($i=$firstLink ; $i<=$lastLink ; $i++):?>
                          <li class="page-item"><a class="page-link" href='?page=<?=$i?>&thema=<?=$thema?>&select=<?=$select?>'><?=$i?> </a></li>
                        <?php endfor?>
                        
                        <?php if($lastLink != $pageCount): ?>
                         <li class="page-item"><a class="page-link" href='?page=<?=$page+5?>&thema=<?=$thema?>&select=<?=$select?>'>> </a></li>
                        <?php endif?>
                      </ul>
                    </div>
      <div style=''>
        <form action='searchRecommand' style='float:right'>
          <input type='hidden' name='page' value='1'>
          <input type='hidden' name='thema' value='<?=$thema?>'>
          <select name='select'>
            <option value='content'>내용</option>
            <option value='title'>제목</option>
            <option value='nickname'>작성자</option>
          </select>
            <input type='input' name='text'>
            <input type='submit' value='검색' class='btn btn-primary'>
        </form>
    </div>
  </div>

  
</body>
</html>