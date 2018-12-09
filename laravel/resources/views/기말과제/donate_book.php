<?php
  $url = 'donateBook';
  session_start();
  require_once('tools.php');
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
  $loginOk = isset($_SESSION['id'])?'true':'false';
  $nicknameCheck = isset($_SESSION['nickname'])?$_SESSION['nickname']:'';
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
  <script>
      function loginCheck(check,buyer,seller,url){
        if(seller == buyer){
          alert('제공자와 구매자의 정보가 같습니다.');
          return;
        }else{
            location.href=url;
        }

      }
  </script>
</head>
<body>
<!--<div id='navi'></div>-->
<?php
  require('navigationbar3.php');
?>

  <div class="contents">
       <h1>책기부</h1>
        <button id="myShowHidebtn" class="btn btn-primary" onclick="loginCheck(<?=$loginOk?>,1,2,'recommend_form?go=donateInsert&url=<?=$url?>')" style='position:fixed;float:right;margin-right:10px;'>책기부하기</button>
       <div class="l-wrapper">

        <ul class="l-row">
          <?php foreach($getOnePageList as $data):?>

            <li class="l-col" style='cursor:pointer;'>
              <?php
                $getData = $data;
                if($data['sale_status']!='sale'){
                  $style='background:#FAAC58';
                }else{
                  $style='';
                }
              ?>
                <div class="editor brackets" style=''>
                    <img class="editor-icon" src="<?=$data['img']?>" width='148px' height='210px' onclick="location.href='donate_book_info?num=<?=$data['num']?>&thema=<?=$data['thema']?>'">
                    <p>작성자:<?=$data['nickname']?></p>
                    <p><?=$data['title']?></p>
                    <?php if($data['sale_status']=='sale'):?>
                    <button type="button" class="btn btn-success btn-product" title="Edit" onclick="loginCheck(<?=$loginOk?>,'<?=$nicknameCheck?>','<?=$data['nickname']?>','orderSample?num=<?=$data['num']?>&title=<?=$data['title']?>&content=<?=$data['title']?>&img=<?=$data['img']?>&thema=<?=$data['thema']?>&nickname=<?=$data['nickname']?>')" ><span class='glyphicon glyphicon-shopping-cart'>책받기</span></button>

                    <?php endif ?>
                    <?php if($data['sale_status']=='sold_out'):?>
                      <span class='btn glyphicon btn-product btn-success'>품절</span>
                    <?php endif ?>
                    <br>
                    
                    <br>
                </div> 
            </li>
          <?php endforeach ?>
         
        </ul>

          <div style='text-align: center;'>
            <ul class="pagination">
              <?php if($page > PAGE_LINK ):?>
                  <li class="page-item"><a class="page-link" href='?page=<?=$page-5?>'>< </a></li>
              <?php endif?>
             <?php for($i=$firstLink ; $i<=$lastLink ; $i++):?>
                <li class="page-item"><a class="page-link" href='?page=<?=$i?>'><?=$i?></a></li>
              <?php endfor?>
              <?php if($lastLink != $pageCount):?>
                <li class="page-item"><a class="page-link" href='?num=<?=$num?>&page=<?=$page+5?>'>> </a></li>
              <?php endif?>
            </ul>
          </div>


      </div>    
    </div>
  
</body>
</html>