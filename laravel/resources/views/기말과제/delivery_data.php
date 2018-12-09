<?php
  
  $url = 'recommend_form';
  session_start();
  require('tools.php');
  require('memberDao.php');
  $go = requestValue('go');
  $url = requestValue('url');
  $num = requestValue('num');
  $page = requestValue('page');
  $title = requestValue('title');

  logoutBack(bdUrl('recommend_board.php',$num,$page));
  $sessionOk = sessionVar('id');
  $mdao = new MemberDao();
  if($sessionOk){
    $member = $mdao -> getMember($sessionOk);
    $img = $member['img'];
    if($img == null){
      $img = "http://www.tangoflooring.ca/wp-content/uploads/2015/07/user-avatar-placeholder.png";
    }
  }

  //
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel='stylesheet' href='css/post.css'>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="js/drag_and_drop.js"></script>
  <script src="js/ajax2.js"></script>
  <script>
    
  </script>
</head>
<body onload="">
<?php
  require('navigationbar3.php');
?>
<div id='test'></div>
    <div class="container">
    <div class="panel-body">
                <table class="table table-striped table-bordered" >
                  <thead>
                    <tr>
                        <th>이름</th>
                        <th>우편번호</th>
                        <th>주소</th>
                        <th>휴대전화</th>
                        <th>집전화</th>
                        <th>배송현황</th>
                    </tr> 
                  </thead>
                  <tbody>
                    <?php foreach($datas as $data):?>
                          <tr>
                            <td><?=$data['name']?></td>
                            <td><?=$data['post_num']?></td>
                            <td><?=$data['addr']?></td>
                            <td><?=$data['phone']?></td>
                            <td><?=$data['tel']?></td>
                            <td>
                                <a href="#" class="btn btn-info"><span class=""></span>배송준비중</a>
                            </td>
                          </tr>
                    <?php endforeach?>
                        </tbody>
                </table>
            
              </div>
    </div>
</body>
</html>