<?php
  $url = 'openBoard';
  //require('navigationbar3.php');
  require('openBoardDao.php');
  
  require('tools.php');
  require('memberDao.php');
  
  session_start();
  $sessionOk = sessionVar('id');
  $mdao = new MemberDao();
  if($sessionOk){
    $member = $mdao -> getMember($sessionOk);
    $img = $member['img'];
    if($img == null){
      $img = "http://www.tangoflooring.ca/wp-content/uploads/2015/07/user-avatar-placeholder.png";
    }
  }
  
  $currentPage = requestValue('page');
  define('ONE_PAGE_LIST',5);
  define('PAGE_LINK',5);
  $loginOk = isset($_SESSION['id']);//sessionVar('id');
  
  $dao = new OpenBoardDao();
  $data = $dao -> getData();

  $listCount = $dao -> getListCount();

  if($listCount>=0){
    $pageCount = ceil($listCount/ONE_PAGE_LIST);
    if($currentPage < 1){
      $currentPage=1;
    }
    if($currentPage > $pageCount){
      $currentPage = $pageCount;
    }

    $start = ($currentPage-1)*ONE_PAGE_LIST;
    $onePageList = $dao -> getOnePageList($start,ONE_PAGE_LIST);

    $firstLink = floor(($currentPage-1)/PAGE_LINK)*PAGE_LINK+1;
    $lastLink = $firstLink + PAGE_LINK -1 ;

    if($lastLink > $pageCount){
      $lastLink = $pageCount;
    }
  }
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
  <script type="text/javascript" src="js/ajax.js"></script>
</head>
<body onload="request('navi','navigationbar.php')">
<!--<div id='navi'></div>-->
<?php
  require('navigationbar3.php');
?>
<script>
     function loginCheck(check){
        if(check){
            location.href='openBoard_register_form?url=<?=$url?>&page=<?=$currentPage?>&num=<?=$num?>&form=insert';
        }else{
            alert('로그인 해주세요!!');
        }
      }
  </script>
   <div class="container">
    <h2>자유게시판</h2>        
    <table class="table table-hover">
      <thead>
        <tr>
          <th>제목</th>
          <th>작성자</th>
          <th>날짜</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($onePageList as $row): ?>
          <?php
            $writer = $mdao -> getNickname($row['nickname']);

          ?>
          <tr onclick="location.href='openBoard_page?num=<?=$row['num']?>&page=1'" style='cursor:pointer;'>
            <td><?= $row['title']?></td>
            <td><img src='<?=$writer['img']?>' style='width:25px;height:25px;' class="avatar img-circle"><?= $row['nickname']?></td>
            <td><?= $row['date']?></td>
          </tr>
        <?php endforeach ?>
      </tbody>
    </table>
    <div style='text-align: center;'>
      <ul class="pagination">
        <?php if($currentPage>PAGE_LINK): ?>
          <li class="page-item"><a class="page-link" href='?page=<?=$currentPage-5?>'><span class='btn btn-outline-dark slidebottomleft'><</span> </a></li>
        <?php endif?>

        <?php for($i=$firstLink ; $i<=$lastLink ; $i++):?>
          <li class="page-item"><a class="page-link" href='?page=<?=$i?>'><?=$i?> </a></li>
        <?php endfor?>
        
        <?php if($lastLink != $pageCount): ?>
         <li class="page-item"><a class="page-link" href='?page=<?=$currentPage+5?>'>> </a></li>
        <?php endif?>
      </ul>
    </div>

    <button id="myShowHidebtn" class="btn btn-primary" onclick="loginCheck(<?=$loginOk?>)" >글쓰기</button>

    <div style='float:right'>
      <form action='search' >
        <input type='hidden' name='page' value='1'>
        <select name='select'>
          <option value='text'>내용</option>
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