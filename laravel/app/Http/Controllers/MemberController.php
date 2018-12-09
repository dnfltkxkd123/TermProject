<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Member;

class MemberController extends Controller
{
    public function insert(){
        require('tool.php');
        $id = requestValue('id');
        $pw = requestValue('pw');
        $url = isset($_REQUEST['url'])?$_REQUEST['url']:'bookCommunityMain';
        $num = requestValue('num');
        $page = requestValue('page'); 
        $thema = requestValue('thema');
        if($id && $pw){
            $member = Member::getMember($id);
            if( $member){
                
                $memberPw = isset($member[0]->pw)?$member[0]->pw:null;
                 $memberID = isset($member[0]->id)?$member[0]->id:null;
                $memberNickname = isset($member[0]->nickname)?$member[0]->nickname:null;
                if($memberPw == $pw){
                    session_start();
                    $_SESSION['id'] = $id;
                    $_SESSION['nickname'] = $memberNickname;
                    //okGo('로그인 성공',bdUrl($url,$num,$page));
                    //return view('기말과제.'.$url);
                    ?>
                    <script type="text/javascript">
                        alert('로그인 성공');
                        //alert('<?=$thema?>');
                        location.href='<?=$url?>?page=<?=$page?>&num=<?=$num?>&thema=<?=$thema?>';
                    </script>
                    <?php
                    exit();
                }else{
                    ?>
                        <script>
                            alert('아이디 또는 비밀번호가 같지 않습니다.');
                        </script>
                    <?php
                }   
            }else{
                ?>
                    <script>
                        alert('아이디 또는 비밀번호가 같지 않습니다.');
                    </script>
                <?php
            }
        }else{
                ?>
                    <script>
                        alert('빈칸을 모두 입력하세요!!');
                    </script>
                <?php
        }
    
}

    public function register(Request $request){
        $id = $request -> input('id');
        $name = $request -> input('name');
        $nickname = $request -> input('nickname');
        $email = $request -> input('email');
        $pw = $request -> input('pw');
        $pw_confirm = $request -> input('pw_confirm');
        $url = $request -> input('url');
        $num = $request -> input('num');
        $currentPage = $request -> input('page');
        $member = Member::getMember($id);
        if($id && $name && $nickname && $email && $pw && $pw_confirm){
            if($request->hasFile('file')){
                $file_name = $id.'_'.$request->file('file')->getClientOriginalName();
            }else{
                $file_name = 'http://www.tangoflooring.ca/wp-content/uploads/2015/07/user-avatar-placeholder.png';
            }
            
            if(file_exists('images/'.$file_name)){
                $file_name ='p'.$file_name;
            }

            $memberID = isset($member[0]->id);//?$member[0]->id:false;
            $memberNickname = isset($member[0]->nickname);//?$member[0]->nickname:false;
            if($memberID/*isset($member[0]->id)?true:false*/){
                    ?>
                    <script>
                        alert('같은 아이디가 있습니다.');
                    </script>
                    <?php
                    exit();
            }

            if($memberNickname/*isset($member[0]->nickname)?true:false*/){
                    ?>
                    <script>
                        alert('같은 닉네임이 있습니다.');
                    </script>
                    <?php
                    exit();
            }
            
            if($pw != $pw_confirm){
                ?>
                <script>
                    alert('비밀번호가 같지 않습니다.');
                </script>
                <?php
                exit();
            }
            
            if($file_name == 'http://www.tangoflooring.ca/wp-content/uploads/2015/07/user-avatar-placeholder.png' ){
                
               Member::registerMember($id,$name,$nickname,$email,$pw,$file_name);
               ?>
                <script>
                    alert('회원등록 성공');
                    location.href='bookCommunityMain';
                </script>
                <?php
                exit();
            }else{
                $img = 'images/'.$file_name;
                Member::registerMember($id,$name,$nickname,$email,$pw,$img);
                $request->file('file')->move("images", $file_name);
                ?>
                <script>
                    alert('회원등록 성공');
                    location.href='bookCommunityMain';
                </script>
                <?php
                exit();
            }

        }else{
            ?>
                <script>
                    alert('빈칸을 모두 입력하세요!!');
                </script>
                <?php
                exit();
        }
    }

    public function memberUpdate(Request $request){
    
        $id = $request -> input('id');
        $name = $request -> input('name');
        $nickname = $request -> input('nickname');
        $email = $request -> input('email');
        $pw = $request -> input('pw');
        $pw_confirm = $request -> input('pw_confirm');
        $url = $request -> input('url');
        $num = $request -> input('num');
        $currentPage = $request -> input('page');
        $member = Member::getMember($id);
        $check = Member::getNMember($nickname);
        $checkID = isset($check[0]->id)?$check[0]->id:'';
        $checkNickname = isset($check[0]->nickname)?$check[0]->nickname:'';
        ?>
            <script type="text/javascript">
                //alert('<?=$id?>/<?=$name?>/<?=$email?>/<?=$pw?>/<?=$nickname?>/');
            </script>
        <?php
        if($name && $nickname && $email && $pw && $pw_confirm){
            


            if($id!=$checkID && $checkNickname){
                    ?>
                    <script>
                        alert('같은 닉네임이 있습니다.');
                    </script>
                    <?php
                    exit();
            }
            
            if($pw != $pw_confirm){
                ?>
                <script>
                    alert('비밀번호가 같지 않습니다.');
                </script>
                
                <?php
                exit();
            }
            session_start();
            if($request->hasFile('file')){
                $file_name = $request->file('file')->getClientOriginalName();
                $file_name = $id.'_update_'.$file_name;
                if(file_exists('images/'.$file_name)){
                    $file_name = 'p_'.$file_name;
                }
                $tmp ='images/'.$file_name;
                $request->file('file')->move("images", $file_name);
                Member::memberUpdate($id,$name,$nickname,$email,$pw,$tmp);
                 $_SESSION['nickname'] = $nickname;
                ?>
                
                <script>
                    alert('회원등록 성공');
                    location.href='bookCommunityMain';
                </script>

                <?php
                
                exit();
            }else{
                
                $file_name = $member[0]->img;

                Member::memberUpdate($id,$name,$nickname,$email,$pw,$file_name);
                $_SESSION['nickname'] = $nickname;
                ?>

                <script>
                    alert('회원정보 수정');
                    location.href='bookCommunityMain';
                </script>
                <?php
                exit();
                
            }

        }else{
            //errorBack('빈칸을 모두 입력하세요!!');
            ?>
                    <script>
                        alert('빈칸을 모두 입력하세요!!');
                    </script>
                    <?php
                    exit();
        }

    }
}