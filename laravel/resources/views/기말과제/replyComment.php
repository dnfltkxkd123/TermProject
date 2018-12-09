<?php for($i=$start ; $i<$start+5 ;$i++):?>
                                        <?php 
                                        $reply = $replyComment[$i];
                                        ?>

                                        <li  class="list-group-item reply replyCount" style='border-color:rgba(0,0,0,0);<?=$display?>' >
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
                                                <img class="img-responsive avatar img-circle" src="<?=$commentImg?>" style='width:100px;height:100px;'/>
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
                                                        <button type="button" class="btn btn-danger btn-xs" title="Delete" onclick="location.href = 'reply_delete.php?num=<?=$reply['num']?>&table=reply_comment'">
                                                          <span class="glyphicon glyphicon-trash">삭제</span>
                                                        </button>
                                                      </div>
                                                    <?php endif?>
                                                   </div>

                                                   <div id='sub_update<?=$subCount?>' style='display:none'>
                                                    <form action='reply_update.php' enctype='multipart/form-data'>
                                                      <textarea   name="text" wrap="virtual" rows='5' class="msg_text"><?=$reply['text']?></textarea>
                                                      <input name='num' type='text' style='display: none' value='<?=$reply['num']?>'>
                                                      <input name='table' type='text' style='display: none' value='reply_comment'>

                                                      <button type="submit" class="btn btn-primary btn-xs" title="Edit" onclick=''>
                                                        <span class="">수정완료</span>
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

                                          <?php endfor ?>