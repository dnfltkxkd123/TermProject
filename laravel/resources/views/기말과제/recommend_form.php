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
<div id='test'></div>
<!--<div id='navi'></div>-->
<?php
  require('navigationbar3.php');
?>
  <div class="container">
     <div class="row">
        <div class="col-md-8 col-md-offset-2">
          <form  action='<?=$go?>' method='post' enctype="multipart/form-data" id='form' >
            <input type="hidden" name="_token" value="<?= csrf_token() ?>">
            <input type="hidden" name="num" value="<?= $num ?>">
            <input type='text' name='page' value='<?=$currentPage?>' style='display:none'>
            <h1>게시글 작성</h1>

            <div class="form-group">
                <label for="title">제목</label>
                <input type="text" class="form-control" name="title" value='<?=$title?>'/>
            </div>

            <div id='dropZone'>
              <label for="title">파일을 드래그 해주세요!! <span class="require">*</span></label>
              <input type='file' id='file' name='file' accept='image/*' onchange="loadFile(event)"/><!--onchange="readURL(this);"-->
              <img id="book" src="http://placehold.it/148x210" alt="your image"  width='148' height='210'/>
                <select class="form-control" style='width:148px;'name='thema'>
                  <option value="역사">역사</option>
                  <option value="백과사전">백과사전</option>
                  <option value="철학">철학</option>
                  <option value="종교">종교</option>
                  <option value="사회과학">사회과학</option>
                  <option value="자연과학">자연과학</option>
                  <option value="기술과학">기술과학</option>
                  <option value="예술">예술</option>
                  <option value="어학">어학</option>
                  <option value="문학">문학</option>
                  <option value="역사">역사</option>
                </select>
            </div>
            <div class="form-group">
              <label for="description">설명</label>
              <textarea rows="5" class="form-control" name="content" ></textarea>
            </div>

            <div class="form-group">
                <button type="button" onclick="fileCheck('#test','<?=$go?>')" class="btn btn-primary">등록</button>
                <button class="btn btn-default">취소</button>
            </div>

          </form>
          
      </div>
    </div>
  </div>
    
</body>
</html>