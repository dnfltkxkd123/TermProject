<?php
  $url='recommend_bookSample2';
  session_start();
  require('tools.php');
  require('recommendDao.php');
  require('commentDao.php');
  require('memberDao.php');
  require('replyCommentDao.php');
  $sessionOk = sessionVar('id');
  $mdao = new MemberDao();
  if($sessionOk){
    $member = $mdao -> getMember($sessionOk);
    $img = $member['img'];
    if($img == null){
      $img = "http://www.tangoflooring.ca/wp-content/uploads/2015/07/user-avatar-placeholder.png";
    }
  }
  
  define('ONE_PAGE_LIST',5);
  define('PAGE_LINK',5);
  $nickname = sessionVar('nickname');
  $currentPage = requestValue('page');
  
  $title = requestValue('title');
  $date = requestValue('date');
  
  $num = requestValue('num');
  $go = isset($go)?$go:'recommend_update';
  $del = isset($del)?$del:'recommend_delete';
  $recommendDao = new RecommendDao();
  $data = $recommendDao -> getRecommendData($num);
  $title = $data['title'];
  $date = $data['date'];
  $thema = $data['thema'];
  $bookImg = $data['img'];
  $content = $data['content'];

  $member = $mdao -> getNickname($data['nickname']);
  $memberImg = $member['img'];

  
  $commentDao = new CommentDao('recommend_comment');
  $commentData = $commentDao -> getCommentData($num);
  $commentCount = $commentDao -> commentCount($num);
  
  
  if($commentCount>=0){
    $pageCount = ceil($commentCount/ONE_PAGE_LIST);
    if($currentPage>$pageCount){
      $currentPage = $pageCount;
    }
    if($currentPage<1){
      $currentPage = 1;
    }
    $start = ($currentPage-1)*ONE_PAGE_LIST;
    $onePageList = $commentDao -> getOnePageList($num,$start,ONE_PAGE_LIST);

    $firstLink = floor(($currentPage-1)/PAGE_LINK)*PAGE_LINK + 1;
    $lastLink =  $firstLink + PAGE_LINK -1;
    if($lastLink > $pageCount){
      $lastLink = $pageCount;
    }
  }
  
  $count = 0;
  $subCount = 0;
  $update_comments = 'update_comment';
  $reply_comment = 'reply_recommend_comment';
  $commentTable = 'recommend_comment';
  $replyDao = new ReplyCommentDao($reply_comment);
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>jQuery Events</title>
    <meta charset="utf-8" content="<?php csrf_token() ?>" name="csrf-token">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel='stylesheet' href='css/post.css'>
  <link rel='stylesheet' href='css/comment.css'>
  <link rel='stylesheet' href='css/recommend3.css'>
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <script src="js/comment.js"></script>
  
</head>
<body> 
  <?php require('navigationbar3.php') ?>
    <div class="box">
        <div class="wrap">
            <ul class="l-row">
                <li class="l-col">
                    <div class="editor">
                        <div class='thema'><span><?=$thema?></span></div>
                        <img src="<?=$bookImg?>" width='148px' height='210px' class="editor-icon"/>
                        <div class='editor-text'>
                          <div>
                          <?php if($nickname == $data['nickname']):?>
                            <input type='button' onclick="check()" value='삭제'  method="post" class='btn btn-primary' style='float:right'>
                            <input type='button' onclick="location.href='recommend_form?go=<?=$go?>&num=<?=$num?>&page=<?=$currentPage?>&title=<?=$title?>'" value='수정'  method="post" class='btn btn-primary' style='float:right;margin-right:5px;'>
                            <?php endif?>
                          </div>
                            <h2><?=$title?></h2>
                            <writer><p>작성자: <img src='<?=$memberImg?>' width='25px' height='25px' class='img-circle'><?=$data['nickname'];?></p></writer>
                            <time><p>추천일:<?=$date?></p></time>
                            <p><?=$content?>
                            </p>
                        </div>
                        
                    </div>
                    <form  action="recommend_comment"   enctype='multipart/form-data' >
                            <div id='commentForm'></div>
                            <div class='text-box'>
                              <br>
                              <span class="label label-info" style='padding:5px;'>댓글작성</span>
                              <textarea  name="text" wrap="virtual" rows='5' style='width:100%'></textarea>
                              <input name='num' type='text' style='display: none' value='<?=$num?>'>
                              <input name='table' type='text' style='display: none' value='<?=$commentTable?>'>
                              <input name='page' type='text' style='display: none' value='<?=$currentPage?>'>
                              <input name='url' type='text' style='display: none' value='<?=$url?>'>
                              <br>
                              <?php if($nickname):?>
                                <input type='submit' value='등록' class='btn btn-primary'> 
                              <?php endif?>
                              <?php if(!$nickname):?>
                                <input type='submit' value='등록' class='btn btn-primary' onclick="alert('로그인 해주세요');return false;"> 
                              <?php endif?>
                              <input type='button' value='전체글' class='btn btn-primary' onclick="location.href='recommend_board.php?page=1&thema=<?=$thema?>'">
                              <br><br>
                            </div>
                    </form>
                    <div class="row" style='padding:10px;'>
                    <div class="panel panel-default widget">
                      <div class="panel-heading">
                         <span class="glyphicon glyphicon-comment"></span>
                         <br>
                         <h3 class="panel-title">댓글수</h3>
                         <span class="label label-info"><?=$commentCount?></span>
                         <br>
                      </div>
                      <div class="panel-body">
                        <ul class="list-group">
                          <?php foreach($onePageList as $comment):?>
                            <li  class="list-group-item" >
                              <article class="row" >
                                <div class="col-md-2 col-sm-2" style='width:150px;height:150px;' ><!-- hidden-xs-->
                                 <figure class="thumbnail" style='border-color:rgba(0,0,0,0);'> 
                                   <?php 
                                      $commentMember = $mdao -> getNickname($comment['nickname']);
                                      $commentImg = $commentMember['img'];
                                      if($commentImg == null){
                                        $commentImg ='http://www.tangoflooring.ca/wp-content/uploads/2015/07/user-avatar-placeholder.png';
                                      }
                                      if($comment['nickname'] == $nickname){
                                        $commentNickname = '나';
                                        $style = "style='color:red;'";
                                      }else{
                                        $commentNickname = $comment['nickname'];
                                        $style = '';
                                      }
                                    ?>
                                    <img class="img-responsive avatar img-circle" src="<?=$commentImg?>" style='width:100px;height:100px;'/>
                                    <figcaption class="text-center" <?=$style?>><?=$commentNickname?></figcaption>
                                  </figure>
                                </div>
                                <div class="col-md-10 col-sm-10">
                                  <div class="panel panel-default arrow left">
                                    <div class="panel-body">
                                      <header class="text-left">
                                        <time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> <?=$comment['date']?></time>
                                      </header>
                                      <div class="comment-post" style='overflow:auto;'><!-- -->
                                        <br>
                                        <p><span><?=$comment['text']?></span></p>
                                        <div class="action">
                                          <button type="button" class="btn btn-primary btn-xs" title="Edit" onclick="changeForm('reply_box<?=$count?>',reply_check,<?=$count?>);"><!--replyForm(<?=$count?>)-->
                                              <span class="glyphicon glyphicon-pencil">답글</span>
                                            </button>
                                          <?php if($nickname == $comment['nickname']):?>
                                            <button type="button" class="btn btn-primary btn-xs" title="Edit" onclick="changeForm('update_comment<?=$count?>',update_check,<?=$count?>)"><!--update_com(<?=$count?>)-->
                                              <span class="glyphicon glyphicon-pencil">수정</span>
                                            </button>
                                            <button type="button" class="btn btn-danger btn-xs" title="Delete" onclick="location.href = 'deleteComment.php?count=<?=$comment['count']?>&table=<?=$commentTable?>'">
                                              <span class="glyphicon glyphicon-trash">삭제</span>
                                            </button>
                                          <?php endif?>
                                          
                                        </div>
                                        <!---->
                                        <div id='update_comment<?=$count?>' style='margin-top:5px;display:none'>
                                          <form action='comment_update.php' enctype='multipart/form-data'>
                                            <textarea   name="text" wrap="virtual" rows='5' class="msg_text" placeholder="수정"></textarea>
                                            <input name='count' type='text' style='display: none' value='<?=$comment['count']?>'>
                                            <input name='table' type='text' style='display: none' value='<?=$commentTable?>'>
                                            <input name='page' type='text' style='display: none' value='<?=$currentPage?>'>
                                            <input name='url' type='text' style='display: none' value='<?=$url?>'>
                                          
                                            <button type="submit" class="btn btn-primary btn-xs" title="Edit" onclick=''>
                                              <span class="">수정완료</span>
                                            </button>
                                            
                                          </form>

                                        </div>
                                       </div>
                                     </div>
                                   </div>
                                 </div>
                               </article>
                               <!---->
                               
                               
                                  <div id='reply_box<?=$count?>' style='display:none;overflow-y:scroll;height:170px;'>
                                    <?php
                                      $replyComment = $replyDao -> getReply($comment['count']);
                                      $replyNum = 0;
                                    ?>
                                    <ul class="list-group"   style='margin-left:150px;'>
                                      <?php foreach($replyComment as $reply):?>
                                        <?php 
                                        $replyNum = $replyNum+1;
                                        $display = '';
                                        if($replyNum>3){
                                          //$display='display:none';
                                        }else{
                                          $display='display:block';
                                        }
                                        ?>

                                        <li  class="list-group-item reply reply<?=$count?> sub<?=$subCount?>" style='border-color:rgba(0,0,0,0);<?=$display?>' >
                                        <?=$subCount?>
                                          <article class="row" >
                                            <div class="col-md-2 col-sm-2" style='width:150px;height:150px;' ><!-- hidden-xs-->
                                             <figure class="thumbnail" style='border-color:rgba(0,0,0,0);'> 
                                               <?php 
                                                  $replyCommentMember = $mdao -> getNickname($reply['nickname']);
                                                  $replyCommentImg = $replyCommentMember['img'];
                                                  if($replyCommentImg == null){
                                                    $replyCommentImg ='http://www.tangoflooring.ca/wp-content/uploads/2015/07/user-avatar-placeholder.png';
                                                  }
                                                  if($reply['nickname'] == $nickname){
                                                    $replyCommentNickname = '나';
                                                    $style = "style='color:red;'";
                                                  }else{
                                                    $replyCommentNickname = $reply['nickname'];
                                                    $style = '';
                                                  }
                                                ?>
                                                <img class="img-responsive avatar img-circle" src="<?=$replyCommentImg?>" style='width:100px;height:100px;'/>
                                                <figcaption class="text-center" <?=$style?>><?=$replyCommentNickname?></figcaption>
                                              </figure>
                                            </div>
                                            <div class="col-md-10 col-sm-10">
                                              <div class="panel panel-default arrow left">
                                                <div class="panel-body">
                                                  <header class="text-left">
                                                    <time class="comment-date" datetime="16-12-2014 01:05"><i class="fa fa-clock-o"></i> <?=$reply['date']?></time>
                                                  </header>
                                                  <div class="comment-post" style='overflow:auto;'><!-- -->
                                                    <br>
                                                    <p><span><?=$reply['text']?></span></p>
                                                    <?php if($nickname == $reply['nickname']):?>
                                                      <div class="action">
                                                        <button type="button" class="btn btn-primary btn-xs" title="Edit" onclick="changeForm('sub_update<?=$subCount?>',sub_update_check,<?=$subCount?>)">
                                                          <span class="glyphicon glyphicon-pencil">수정</span>
                                                        </button>
                                                        <button type="button" class="btn btn-danger btn-xs" title="Delete" onclick="replyDelete(<?=$subCount?>)">
                                                          <span class="glyphicon glyphicon-trash">삭제</span>
                                                        </button>
                                                      </div>
                                                    <?php endif?>
                                                   </div>

                                                   <div id='sub_update<?=$subCount?>' style='display:none'>
                                                    <form action='reply_update.php' enctype='multipart/form-data' id='replyUpdate<?=$subCount?>'>
                                                      <textarea   name="text" wrap="virtual" rows='5' class="msg_text"><?=$reply['text']?></textarea>
                                                      <input name='num' type='text' style='display: none' value=<?=$reply['num']?> >
                                                      <input name='table' type='text' style='display: none' value='<?=$reply_comment?>'>
                                                      <input name='count' type='text' style='display: none' value='<?=$reply['count']?>'>
                                                      <input name='nickname' type='text' style='display: none' value='<?=$reply['nickname']?>'>
                                                      <input name='subCount' type='text' style='display: none' value='<?=$subCount?>'>
                                                      <input type="button" class="btn btn-primary btn-xs" title="Edit" onclick="replyUpdate(<?=$subCount?>)" value='수정완료'>
                                                      </button>
                                                    </form>
                                                  </div>
                                                  <script>
                                                    sub_update_check[subCount] = false;
                                                    subCount++;
                                                    <?=$subCount+=1?>
                                                  </script>
                                                  
                                                 </div>
                                               </div>
                                             </div>
                                           </article>
                                          </li>

                                          
                                          
                                          <?php endforeach ?>
                                          <div id="subUl<?=$count?>">
                                          </div>
                                          <button type="submit" class="btn btn-primary btn-xs" title="Edit" onclick="replyComment('.reply<?=$count?>')">
                                            <span class="">더보기</span>
                                          </button>
                                          <button type="submit" class="btn btn-primary btn-xs" title="Edit" onclick="changeForm('reply_box<?=$count?>',reply_check,<?=$count?>);">
                                            <span class="">숨기기</span>
                                          </button>
                                          <div id='reply<?=$count?>' style='margin-top:5px;' >
                                          <?php if ($sessionOk): ?>
                                            <form action='reply_insert.php' method='post' enctype='multipart/form-data' id="replyInsert<?=$count?>">
                                              <input name='table' type='text' style='display: none' value='<?=$reply_comment?>'>
                                              <input name='count' type='text' style='display: none' value='<?=$comment['count']?>'>
                                              <input name='nickname' type='text' style='display: none' value='<?=$nickname?>'>
                                              
                                              
                                              <textarea   name="text" wrap="virtual" rows='5' class="msg_text"  placeholder='답글'></textarea>
                                              <input type="button" class="btn btn-primary btn-xs" title="Edit" onclick="plusReply(<?=$count?>)" value='답글등록'>
                                                      </button>
                                              
                                              <!--<button type="submit" class="btn btn-primary btn-xs" title="Edit" onclick="">
                                                <span class="">답글등록</span>
                                              </button>-->
                                            
                                            </form>
                                          <?php endif ?>
                                          <?php if(!$sessionOk): ?>
                                            <form>
                                              <textarea  name="text" wrap="virtual" rows='5' class="msg_text" placeholder='답글'></textarea>
                                              <button type="button" class="btn btn-primary btn-xs" title="Edit" onclick="alert('로그인 해주세요!')">
                                                <span class="">답글등록</span>
                                              </button>
                                            </form>
                                          <?php endif ?>
                                        </div>

                                      </ul>
                                      <script>
                                          //update_comments[count] = $('#update_comment'+count);
                                          //reply_comments[count] = $('#reply'+count);
                                          update_check[count] = false;
                                          reply_check[count] = false;
                                          reply[count] = false;
                                          //reply_boxs[count] = $('#reply_box'+count);
                                           //block(count);
                                           count++;
                                           <?php $count+=1 ?>
                                        </script>
                               </div>
                                 <!---->     
                              </li>
                              <?php endforeach ?>
                                <br>
                                <div style='text-align:center;'>
                                  <?php if($currentPage > PAGE_LINK ):?>
                                    <a href='recommend_bookSample2.php?num=<?=$num?>&page=<?=$currentPage-5?>'>< </a>
                                  <?php endif?>

                                  <?php for($i=$firstLink ; $i<=$lastLink ; $i++): ?>
                                    <a href='recommend_bookSample2.php?num=<?=$num?>&page=<?=$i?>'><?= $i ?> </a>
                                  <?php endfor?>

                                  <?php if($lastLink != $pageCount):?>
                                    <a href='recommend_bookSample2.php?num=<?=$num?>&page=<?=$currentPage+5?>'>> </a>
                                  <?php endif?>

                                </div>
                            </ul>
                          </div> 
                        </div>
                      </div>
                </li>
                
            </ul>
        </div>
    
                
</body>
</html>