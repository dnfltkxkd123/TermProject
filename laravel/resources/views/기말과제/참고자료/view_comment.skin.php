<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

$captcha_html = "";
if ($is_guest && $board['bo_comment_level'] < 2) {
    $captcha_html = captcha_html_overriding('_comment');
}
?>

<script>
// 글자수 제한
var char_min = parseInt(<?php echo $comment_min ?>); // 최소
var char_max = parseInt(<?php echo $comment_max ?>); // 최대
</script>

<div class="row h1"><p class="hidden">한줄간격주기</p></div>

<!-- 댓글 시작 { -->
<div id="bo_vc" class="col-xs-12 well">	
    <h2 class="sr-only">댓글목록</h2>
    <?php
    $cmt_amt = count($list);
    for ($i=0; $i<$cmt_amt; $i++) {
        $comment_id = $list[$i]['wr_id'];
        $cmt_depth = ""; // 댓글단계
        $cmt_depth = strlen($list[$i]['wr_comment_reply']) * 20;
        $comment = $list[$i]['content'];
        /*
        if (strstr($list[$i]['wr_option'], "secret")) {
            $str = $str;
        }
        */
        $comment = preg_replace("/\[\<a\s.*href\=\"(http|https|ftp|mms)\:\/\/([^[:space:]]+)\.(mp3|wma|wmv|asf|asx|mpg|mpeg)\".*\<\/a\>\]/i", "<script>doc_write(obj_movie('$1://$2.$3'));</script>", $comment);
        $cmt_sv = $cmt_amt - $i + 1; // 댓글 헤더 z-index 재설정 ie8 이하 사이드뷰 겹침 문제 해결

		// 글쓴이 이름 사이드뷰
		$tmp_name = get_text(cut_str($list[$i]['wr_name'], $config['cf_cut_name'])); // 설정된 자리수 만큼만 이름 출력
		$tmp_name2 = cut_str($list[$i]['wr_name'], $config['cf_cut_name']); // 설정된 자리수 만큼만 이름 출력
		if ($board['bo_use_sideview'])
			$list[$i]['name'] = get_sideview_overriding($list[$i]['mb_id'], $tmp_name2, $list[$i]['wr_email'], $list[$i]['wr_homepage']);
		else
			$list[$i]['name'] = '<span class="'.($list[$i]['mb_id']?'sv_member':'sv_guest').'">'.$tmp_name.'</span>';
     ?>
    <div id="c_<?php echo $comment_id ?>" <?php if ($cmt_depth) { ?>style="margin-left:<?php echo $cmt_depth ?>px;border-top-color:#e0e0e0"<?php } ?> class="panel panel-default">
        <div style="z-index:<?php echo $cmt_sv; ?>" class="col-xs-12">
			<div class="row h4"><p class="hidden">한줄간격주기</p></div>
            <h1 class="sr-only"><?php echo get_text($list[$i]['wr_name']); ?>님의 댓글</h1>
			<?php if ($cmt_depth) { ?><img src="<?php echo $board_skin_url ?>/img/icon_reply.gif" class="icon_reply" alt="댓글의 댓글"><?php } ?>
			<ul class="list-inline">				
				<li><i class="fa fa-fw fa-user"></i><?php echo $list[$i]['name'] ?>				
				<?php if ($is_ip_view) { ?>
				<li><span class="sr-only">아이피</span>
				<span class="bo_vc_hdinfo">(<?php echo $list[$i]['ip']; ?>)</span></li>
				<?php } ?>
				<li><span class="sr-only">작성일</span>
				<i class="fa fa-fw fa-calendar"></i><span class="bo_vc_hdinfo"><time datetime="<?php echo date('Y-m-d\TH:i:s+09:00', strtotime($list[$i]['datetime'])) ?>"><?php echo $list[$i]['datetime'] ?></time></span></li>
				<?php
				include(G5_SNS_PATH.'/view_comment_list.sns.skin.php');
				?>
			</ul>
        </div>
		
        <!-- 댓글 출력 -->
		<div class="panel-body">
			<p>
				<?php if (strstr($list[$i]['wr_option'], "secret")) { ?><img src="<?php echo $board_skin_url; ?>/img/icon_secret.gif" alt="비밀글"><?php } ?>
				<?php echo $comment ?>
			</p>

			<span id="edit_<?php echo $comment_id ?>"></span><!-- 수정 -->
			<span id="reply_<?php echo $comment_id ?>"></span><!-- 답변 -->

			<input type="hidden" value="<?php echo strstr($list[$i]['wr_option'],"secret") ?>" id="secret_comment_<?php echo $comment_id ?>">
			<textarea id="save_comment_<?php echo $comment_id ?>" style="display:none"><?php echo get_text($list[$i]['content1'], 0) ?></textarea>
		</div>

        <?php if($list[$i]['is_reply'] || $list[$i]['is_edit'] || $list[$i]['is_del']) {
            $query_string = clean_query_string($_SERVER['QUERY_STRING']);

            if($w == 'cu') {
                $sql = " select wr_id, wr_content, mb_id from $write_table where wr_id = '$c_id' and wr_is_comment = '1' ";
                $cmt = sql_fetch($sql);
                if (!($is_admin || ($member['mb_id'] == $cmt['mb_id'] && $cmt['mb_id'])))
                    $cmt['wr_content'] = '';
                $c_wr_content = $cmt['wr_content'];
            }

            $c_reply_href = './board.php?'.$query_string.'&amp;c_id='.$comment_id.'&amp;w=c#bo_vc_w';
            $c_edit_href = './board.php?'.$query_string.'&amp;c_id='.$comment_id.'&amp;w=cu#bo_vc_w';
         ?>
        <div class="text-right">
            <ul class="list-inline">
                <?php if ($list[$i]['is_reply']) { ?><li><a href="<?php echo $c_reply_href;  ?>" onclick="comment_box('<?php echo $comment_id ?>', 'c'); return false;">답변</a></li><?php } ?>
                <?php if ($list[$i]['is_edit']) { ?><li><a href="<?php echo $c_edit_href;  ?>" onclick="comment_box('<?php echo $comment_id ?>', 'cu'); return false;">수정</a></li><?php } ?>
                <?php if ($list[$i]['is_del'])  { ?><li><a href="<?php echo $list[$i]['del_link'];  ?>" onclick="return comment_delete();">삭제</a></li><?php } ?>
            </ul>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
    <?php if ($i == 0) { //댓글이 없다면 ?><div class="panel panel-default"><div class="panel-body text-center"><p id="bo_vc_empty">등록된 댓글이 없습니다.</p></div></div><?php } ?>

</div>
<!-- } 댓글 끝 -->

<?php if ($is_comment_write) {
    if($w == '')
        $w = 'c';
?>
<!-- 댓글 쓰기 시작 { -->
<div id="bo_vc_w" class="col-xs-12">
	<div class="row h1"><p class="hidden">한줄간격주기</p></div>
    <h2 class="sr-only">댓글쓰기</h2>
    <form name="fviewcomment" action="./write_comment_update.php" onsubmit="return fviewcomment_submit(this);" method="post" autocomplete="off" role="form">
    <input type="hidden" name="w" value="<?php echo $w ?>" id="w">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
    <input type="hidden" name="comment_id" value="<?php echo $c_id ?>" id="comment_id">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="is_good" value="">

    <div class="panel panel-default">
		<div class="panel-body">
			<table class="table">
			<tbody>
			<?php if ($is_guest) { ?>
			<tr>
				<th scope="row" class="w120 hidden-xs"><label for="wr_name" class="control-label">이름<strong class="sr-only sound_only"> 필수</strong></label></th>
				<td><p class="hidden visible-xs"><label for="wr_name" class="control-label">이름<strong class="sr-only sound_only"> 필수</strong></label></p><div class="col-sm-3 zero-padding"><input type="text" name="wr_name" value="<?php echo get_cookie("ck_sns_name"); ?>" id="wr_name" required class="frm_input required form-control" size="5" maxLength="20"></div></td>
			</tr>
			<tr>
				<th scope="row" class="w120 hidden-xs"><label for="wr_password" class="control-label">비밀번호<strong class="sr-only sound_only"> 필수</strong></label></th>
				<td><p class="hidden visible-xs"><label for="wr_password" class="control-label">비밀번호<strong class="sr-only sound_only"> 필수</strong></label></p><div class="col-sm-3 zero-padding"><input type="password" name="wr_password" id="wr_password" required class="frm_input required form-control" size="10" maxLength="20"></div></td>
			</tr>
			<?php } ?>
			<tr>
				<th scope="row" class="w120 hidden-xs"><label for="wr_secret" class="control-label">비밀글사용</label></th>
				<td><p class="hidden visible-xs"><label for="wr_secret" class="control-label">비밀글사용</label></p><input type="checkbox" name="wr_secret" value="secret" id="wr_secret"></td>
			</tr>
			<?php if ($is_guest) { ?>
			<tr>
				<th scope="row" class="w120 hidden-xs"><label for="captcha_key" class="control-label">자동등록방지</label></th>
				<td><p class="hidden visible-xs"><label for="captcha_key" class="control-label">자동등록방지</label></p><?php echo $captcha_html; ?></td>
			</tr>
			<?php } ?>
			<?php
			if($board['bo_use_sns'] && ($config['cf_facebook_appid'] || $config['cf_twitter_key'])) {
			?>
			<tr>
				<th scope="row" class="w120 hidden-xs"><label class="control-label">SNS 동시등록</label></th>
				<td id="bo_vc_send_sns"></td>
			</tr>
			<?php
			}
			?>
			<tr>
				<th scope="row" class="w120 hidden-xs"><label for="wr_content" class="control-label">내용</label></th>
				<td>
					<p class="hidden visible-xs"><label for="wr_content" class="control-label">내용</label></p>
					<?php if ($comment_min || $comment_max) { ?><strong id="char_cnt"><span id="char_count"></span>글자</strong><?php } ?>
					<textarea id="wr_content" name="wr_content" maxlength="10000" required class="required form-control" title="내용"
					<?php if ($comment_min || $comment_max) { ?>onkeyup="check_byte('wr_content', 'char_count');"<?php } ?>><?php echo $c_wr_content;  ?></textarea>
					<?php if ($comment_min || $comment_max) { ?><script> check_byte('wr_content', 'char_count'); </script><?php } ?>
					<script>
					$(document).on("keyup change", "textarea#wr_content[maxlength]", function() {
						var str = $(this).val()
						var mx = parseInt($(this).attr("maxlength"))
						if (str.length > mx) {
							$(this).val(str.substr(0, mx));
							return false;
						}
					});
					</script>
				</td>
			</tr>
			</tbody>
			</table>
		</div>

		<div class="btn_confirm panel-footer text-center">
			<input type="submit" id="btn_submit" class="btn_submit btn btn-danger" value="댓글등록">
		</div>
	
	</div>

    </form>
</div>

<script>
var save_before = '';
var save_html = document.getElementById('bo_vc_w').innerHTML;

function good_and_write()
{
    var f = document.fviewcomment;
    if (fviewcomment_submit(f)) {
        f.is_good.value = 1;
        f.submit();
    } else {
        f.is_good.value = 0;
    }
}

function fviewcomment_submit(f)
{
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자

    f.is_good.value = 0;

    var subject = "";
    var content = "";
    $.ajax({
        url: g5_bbs_url+"/ajax.filter.php",
        type: "POST",
        data: {
            "subject": "",
            "content": f.wr_content.value
        },
        dataType: "json",
        async: false,
        cache: false,
        success: function(data, textStatus) {
            subject = data.subject;
            content = data.content;
        }
    });

    if (content) {
        alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
        f.wr_content.focus();
        return false;
    }

    // 양쪽 공백 없애기
    var pattern = /(^\s*)|(\s*$)/g; // \s 공백 문자
    document.getElementById('wr_content').value = document.getElementById('wr_content').value.replace(pattern, "");
    if (char_min > 0 || char_max > 0)
    {
        check_byte('wr_content', 'char_count');
        var cnt = parseInt(document.getElementById('char_count').innerHTML);
        if (char_min > 0 && char_min > cnt)
        {
            alert("댓글은 "+char_min+"글자 이상 쓰셔야 합니다.");
            return false;
        } else if (char_max > 0 && char_max < cnt)
        {
            alert("댓글은 "+char_max+"글자 이하로 쓰셔야 합니다.");
            return false;
        }
    }
    else if (!document.getElementById('wr_content').value)
    {
        alert("댓글을 입력하여 주십시오.");
        return false;
    }

    if (typeof(f.wr_name) != 'undefined')
    {
        f.wr_name.value = f.wr_name.value.replace(pattern, "");
        if (f.wr_name.value == '')
        {
            alert('이름이 입력되지 않았습니다.');
            f.wr_name.focus();
            return false;
        }
    }

    if (typeof(f.wr_password) != 'undefined')
    {
        f.wr_password.value = f.wr_password.value.replace(pattern, "");
        if (f.wr_password.value == '')
        {
            alert('비밀번호가 입력되지 않았습니다.');
            f.wr_password.focus();
            return false;
        }
    }

    <?php if($is_guest) echo chk_captcha_js();  ?>

    set_comment_token(f);

    document.getElementById("btn_submit").disabled = "disabled";

    return true;
}

function comment_box(comment_id, work)
{
    var el_id;
    // 댓글 아이디가 넘어오면 답변, 수정
    if (comment_id)
    {
        if (work == 'c')
            el_id = 'reply_' + comment_id;
        else
            el_id = 'edit_' + comment_id;
    }
    else
        el_id = 'bo_vc_w';

    if (save_before != el_id)
    {
        if (save_before)
        {
            document.getElementById(save_before).style.display = 'none';
            document.getElementById(save_before).innerHTML = '';
        }

        document.getElementById(el_id).style.display = '';
        document.getElementById(el_id).innerHTML = save_html;
        // 댓글 수정
        if (work == 'cu')
        {
            document.getElementById('wr_content').value = document.getElementById('save_comment_' + comment_id).value;
            if (typeof char_count != 'undefined')
                check_byte('wr_content', 'char_count');
            if (document.getElementById('secret_comment_'+comment_id).value)
                document.getElementById('wr_secret').checked = true;
            else
                document.getElementById('wr_secret').checked = false;
        }

        document.getElementById('comment_id').value = comment_id;
        document.getElementById('w').value = work;

        if(save_before)
            $("#captcha_reload").trigger("click");

        save_before = el_id;
    }
}

function comment_delete()
{
    return confirm("이 댓글을 삭제하시겠습니까?");
}

comment_box('', 'c'); // 댓글 입력폼이 보이도록 처리하기위해서 추가 (root님)

<?php if($board['bo_use_sns'] && ($config['cf_facebook_appid'] || $config['cf_twitter_key'])) { ?>
// sns 등록
$(function() {
    $("#bo_vc_send_sns").load(
        "<?php echo $board_skin_url; ?>/view_comment_write.sns.skin.php?bo_table=<?php echo $bo_table; ?>",
        function() {
            save_html = document.getElementById('bo_vc_w').innerHTML;
        }
    );
});
<?php } ?>
</script>
<?php } ?>
<!-- } 댓글 쓰기 끝 -->