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
  <link rel='stylesheet' href='css/recommend3.css'>
  <script src="js/ajax2.js"></script>

  
<script>

$(document).ready(function(){
  var myKey = "sX0sMAuo3SEqKBxSnhXA9g"; // sweet tracker에서 발급받은 자신의 키 넣는다./
  
    // 택배사 목록 조회 company-api
        $.ajax({
            type:"GET",
            dataType : "json",
            url:"http://info.sweettracker.co.kr/api/v1/companylist?t_key="+myKey,
            success:function(data){
                
                // 방법 1. JSON.parse 이용하기
                var parseData = JSON.parse(JSON.stringify(data));
                console.log(parseData.Company); // 그중 Json Array에 접근하기 위해 Array명 Company 입력
                //parse 메소드는 string 객체를 json 객체로 변환
                //stringify 메소드는 json 객체를 String 객체로 변환

                // 방법 2. Json으로 가져온 데이터에 Array로 바로 접근하기
                var CompanyArray = data.Company; // Json Array에 접근하기 위해 Array명 Company 입력
                console.log(CompanyArray); 
                
                var myData="";
                $.each(CompanyArray,function(key,value) {
                    myData += ('<option value='+value.Code+'>' +value.Name + '</option>');

                    //alert(value.Code);                
                });
                $("#tekbeCompnayList").html(myData);
            }
        })
    })

    function insertInvoiceNum(url){
      var formData = new FormData($('#form')[0]);
      //alert(formData.get('invoice_number'));
      $.ajax({
        type:'post',
        url:url,
        data:formData,
        cache: false, 
        processData: false, 
         contentType : false,
        success:function(data){
          alert('성공');
          location.href='soldBook?seller=<?=$sessionOk?>';
        }, 
        error: function (jqXHR, textStatus, errorThrown) { 
          alert('오류');
         } 
      })
    }
    </script>
</head>
<body onload="">
<?php
  require('navigationbar3.php');
?>
<div id='test'></div>
              
                
    <div class="container">
    <div class="panel-body">

                      <?php foreach($product_datas as $data): ?>
                        <?php $member = $mdao -> getNickname($data['nickname']);
                              $memberImg = $member['img'];
                         ?>
                        <div class='thema'><span><?=$data['thema']?></span></div>
                        <img src="<?=$data['img']?>" width='148px' height='210px' class="editor-icon"/>
                        <div class='editor-text'>
                            <h2><?=$data['title']?></h2>
                            <writer><p>작성자: <img src='<?=$memberImg?>' width='25px' height='25px' class='img-circle'><?=$data['nickname'];?></p></writer>
                            <time><p>추천일:<?=$data['date']?></p></time>
                            <p><?=$data['content']?>
                            </p>
                        </div>
                      <?php endforeach?>
                      <br><br><br><br><br>
        <?php foreach($datas as $data):?>
            <form action='' id='form'>
                <table class="table table-striped table-bordered" >
                  <input type="hidden" name="_token" value="<?= csrf_token() ?>">
                  <input type="hidden" name="product_num" value="<?= $data['product_num'] ?>">
                  <thead>
                    <tr>
                        <th>이름</th>
                        <th>우편번호</th>
                        <th>주소</th>
                        <th>휴대전화</th>
                        <th>집전화</th>
                        <th>택배회사</th>
                        <th>운송번호</th>
                        <th>등록</th>
                    </tr> 
                  </thead>
                  <tbody>
                    
                          <tr>
                            <td><?=$data['name']?></td>
                            <td><?=$data['post_num']?></td>
                            <td><?=$data['addr']?></td>
                            <td><?=$data['phone']?></td>
                            <td><?=$data['tel']?></td>
                            <td>
                              <select id='tekbeCompnayList' name="code"></select>
                            </td>
                            <td><input type="text" id="invoiceNumberText" name="invoice_number" size='8'></td>
                            <td>
                                <a href="#" class="btn btn-info" onclick="insertInvoiceNum('insert_invoice_num')"><span class=""></span>배송정보등록</a>
                            </td>
                          </tr>
                    <?php endforeach?>
                        </tbody>
                </table>
              </form>
        </div>
    </div>
</body>
</html>