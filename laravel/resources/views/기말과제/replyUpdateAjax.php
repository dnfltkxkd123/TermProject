<?php
  require('tools.php');
  require('memberDao.php');
  require('replyCommentDao.php');
  $mdao = new MemberDao();
  $num = requestValue('num');
  $text = requestValue('text');
  $table = requestValue('table');
  $count = requestValue('count');
  $nickname = requestValue('nickname');
  $subCount = requestValue('subCount');
  ?>
  <script>
    ///alert('<?=$num?>/<?=$table?>/<?=$count?>/<?=$subCount?>/<?=$nickname?>');
  </script>
  <?php
  $replyDao = new ReplyCommentDao($table);
  $replyDao -> updateReply($num,$text);
  $replyComment = $replyDao -> getReply2($num);
?>     
<?php foreach($replyComment as $reply):?>   
                         

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

                                                   <div id='sub_update<?=$subCount?>' style=''>
                                                    <form action='reply_update.php' enctype='multipart/form-data' id='replyUpdate<?=$subCount?>'>
                                                      <textarea   name="text" wrap="virtual" rows='5' class="msg_text"><?=$reply['text']?></textarea>
                                                      <input name='num' type='text' style='display: none' value=<?=$reply['num']?> >
                                                      <input name='table' type='text' style='display: none' value='<?=$table?>'>
                                                      <input name='count' type='text' style='display: none' value='<?=$reply['count']?>'>
                                                      <input name='nickname' type='text' style='display: none' value='<?=$reply['nickname']?>'>
                                                      <input name='subCount' type='text' style='display: none' value=<?=$subCount?> >
                                                      <input type="button" class="btn btn-primary btn-xs" title="Edit" onclick="replyUpdate(<?=$subCount?>)" value='수정완료'>
                                                      </button>
                                                    </form>
                                                  </div>
                                                  
                                                 </div>
                                               </div>
                                             </div>
                                           </article>                          
<?php endforeach?>                              