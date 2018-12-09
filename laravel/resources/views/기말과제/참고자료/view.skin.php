<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// 스킨 공통 함수
@include_once($board_skin_path.'/skin.common.lib.php');

// 글쓴이 이름 사이드뷰
$tmp_name = get_text(cut_str($view['wr_name'], $config['cf_cut_name'])); // 설정된 자리수 만큼만 이름 출력
$tmp_name2 = cut_str($view['wr_name'], $config['cf_cut_name']); // 설정된 자리수 만큼만 이름 출력
if ($board['bo_use_sideview'])
	$view['name'] = get_sideview_overriding($view['mb_id'], $tmp_name2, $view['wr_email'], $view['wr_homepage']);
else
	$view['name'] = '<span class="'.($view['mb_id']?'sv_member':'sv_guest').'">'.$tmp_name.'</span>';

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
//?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 게시물 읽기 시작 { -->
<div id="bo_v_table" class="sr-only"><?php echo $board['bo_subject']; ?></div>

<div class="col-xs-12">

	<div class="row h1"><p class="hidden">한줄간격주기</p></div>

    <div class="col-xs-12">
        <h4 id="bo_v_title">
            <b><?php
            if ($category_name) echo $view['ca_name'].' | '; // 분류 출력 끝
            echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력
            ?></b>
        </h4>
    </div>

    <div class="col-xs-12">
        <h2 class="sr-only">페이지 정보</h2>
		<ul class="list-inline">
			<li>
				<i class="fa fa-fw fa-user"></i>
				<span class="sr-only sound_only">작성자</span>
				<b><?php echo $view['name'] ?><?php if ($is_ip_view) { echo "&nbsp;($ip)"; } ?></b>
			</li>
			<li>
				<i class="fa fa-fw fa-calendar"></i>
				<span class="sr-only sound_only">작성일</span>
				<b><?php echo date("y-m-d H:i", strtotime($view['wr_datetime'])) ?></b>
			</li>
			<li>
				<i class="fa fa-fw fa-eye"></i>
				<span class="sr-only sound_only">조회</span>
				<b><?php echo number_format($view['wr_hit']) ?>회</b>
			</li>
			<li>
				<i class="fa fa-fw fa-comments-o"></i>
				<span class="sr-only sound_only">댓글</span>
				<b><?php echo number_format($view['wr_comment']) ?>건</b>
			</li>
		</ul>
    </div>

    <?php
    if ($view['file']['count']) {
        $cnt = 0;
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
                $cnt++;
        }
    }
     ?>

    <?php if($cnt) { ?>
    <!-- 첨부파일 시작 { -->
    <div class="col-xs-12 well">
        <h2 class="sr-only">첨부파일</h2>

        <ul class="list-unstyled">
        <?php
        // 가변 파일
        for ($i=0; $i<count($view['file']); $i++) {
            if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
         ?>
            <li>
                <a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download">
                    <img src="<?php echo $board_skin_url ?>/img/icon_file.gif" alt="첨부">
                    <strong><?php echo $view['file'][$i]['source'] ?></strong>
                    <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
                </a>
				<p>
					<ul class="list-inline">
						<li><span class="bo_v_file_cnt"><i class="fa fa-download fa-fw"></i><span class="hidden-xs"> 다운로드 :</span> <?php echo $view['file'][$i]['download'] ?>회</span></li>
						<li><span><i class="fa fa-calendar fa-fw"></i><span class="hidden-xs"> DATE :</span> <?php echo $view['file'][$i]['datetime'] ?></span></li>
					</ul>
				</p>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </div>
    <!-- } 첨부파일 끝 -->
    <?php } ?>

    <?php
	$tmp = trim(implode('', $view['link']));
    if (!empty($tmp)/*$view['link']*/) {
     ?>
     <!-- 관련링크 시작 { -->
    <div class="col-xs-12 well">
        <h2 class="sr-only">관련링크</h2>
        <ul class="list-unstyled">
        <?php
        // 링크
        $cnt = 0;
        for ($i=1; $i<=count($view['link']); $i++) {
            if ($view['link'][$i]) {
                $cnt++;
                $link = cut_str($view['link'][$i], 70);
         ?>
            <li>
                <a href="<?php echo $view['link_href'][$i] ?>" target="_blank">
                    <img src="<?php echo $board_skin_url ?>/img/icon_link.gif" alt="관련링크">
                    <strong><?php echo $link ?></strong>
                </a>
				<p>
					<span class="bo_v_link_cnt"><i class="fa fa-link fa-fw"></i><span class="hidden-xs"> 연결 :</span> <?php echo $view['link_hit'][$i] ?>회 </span>
				</p>
            </li>
        <?php
            }
        }
         ?>
        </ul>
    </div>
    <!-- } 관련링크 끝 -->
    <?php } ?>

    <!-- 게시물 상단 버튼 시작 { -->
	<div class="row h4"><p class="hidden">한줄간격주기</p></div>

    <div id="bo_v_top" class="col-xs-12 zero-padding">
        <?php
        ob_start();
         ?>

		<div class="row h4"><p class="hidden">한줄간격주기</p></div>

		<div class="btn-group btn-group-justified hidden visible-xs">
			<?php if ($prev_href || $next_href) { ?>
			<?php if ($prev_href) { ?><a href="<?php echo $prev_href ?>" class="btn btn-default">이전글</a><?php } ?>
            <?php if ($next_href) { ?><a href="<?php echo $next_href ?>" class="btn btn-default">다음글</a><?php } ?>
			<?php } ?>
			<?php if ($copy_href) { ?><a href="<?php echo $copy_href ?>" class="btn btn-danger link-btn" onclick="board_move(this.href); return false;">복사</a><?php } ?>
			<?php if ($move_href) { ?><a href="<?php echo $move_href ?>" class="btn btn-danger link-btn" onclick="board_move(this.href); return false;">이동</a><?php } ?>
		</div>

		<div class="row h4"><p class="hidden">한줄간격주기</p></div>

        <?php if ($prev_href || $next_href) { ?>
        <ul class="bo_v_nb list-inline pull-left hidden-xs">
            <?php if ($prev_href) { ?><li class="zero-padding"><a href="<?php echo $prev_href ?>" class="btn btn-default">이전글</a></li><?php } ?>
            <?php if ($next_href) { ?><li class="zero-padding"><a href="<?php echo $next_href ?>" class="btn btn-default">다음글</a></li><?php } ?>
        </ul>
        <?php } ?>		

        <ul class="bo_v_com list-inline pull-right">
            <?php if ($update_href) { ?><li class="zero-padding"><a href="<?php echo $update_href ?>" class="btn btn-default">수정</a></li><?php } ?>
            <?php if ($delete_href) { ?><li class="zero-padding"><a href="<?php echo $delete_href ?>" class="btn btn-default" onclick="del(this.href); return false;">삭제</a></li><?php } ?>
            <?php if ($copy_href) { ?><li class="zero-padding hidden-xs"><a href="<?php echo $copy_href ?>" class="btn btn-danger link-btn" onclick="board_move(this.href); return false;">복사</a></li><?php } ?>
            <?php if ($move_href) { ?><li class="zero-padding hidden-xs"><a href="<?php echo $move_href ?>" class="btn btn-danger link-btn" onclick="board_move(this.href); return false;">이동</a></li><?php } ?>
            <?php if ($search_href) { ?><li class="zero-padding"><a href="<?php echo $search_href ?>" class="btn btn-default">검색</a></li><?php } ?>
            <li class="zero-padding"><a href="<?php echo $list_href ?>" class="btn btn-default">목록</a></li>
            <?php if ($reply_href) { ?><li class="zero-padding"><a href="<?php echo $reply_href ?>" class="btn btn-default">답변</a></li><?php } ?>
            <?php if ($write_href) { ?><li class="zero-padding"><a href="<?php echo $write_href ?>" class="btn btn-primary link-btn">글쓰기</a></li><?php } ?>
        </ul>
        <?php
        $link_buttons = ob_get_contents();
        ob_end_flush();
         ?>
    </div>
    <!-- } 게시물 상단 버튼 끝 -->

    <div class="col-xs-12">
        <h2 id="bo_v_atc_title" class="sr-only">본문</h2>

        <?php
        // 파일 출력
        $v_img_count = count($view['file']);
        if($v_img_count) {
            echo "<div id=\"bo_v_img\" class=\"col-xs-12\">\n";

            for ($i=0; $i<=count($view['file']); $i++) {
                if ($view['file'][$i]['view']) {
                    //echo $view['file'][$i]['view'];
                    echo get_view_thumbnail_overriding($view['file'][$i]['view']);
                }
            }

            echo "</div>\n";
        }
         ?>

        <!-- 본문 내용 시작 { -->
        <div id="bo_v_con" class="col-xs-12 kor"><?php echo get_view_thumbnail_overriding($view['content']); ?></div>
        <?php//echo $view['rich_content']; // {이미지:0} 과 같은 코드를 사용할 경우 ?>
        <!-- } 본문 내용 끝 -->

        <?php if ($is_signature) { ?><div class="row h1"><p class="hidden">한줄간격주기</p></div><div class="col-xs-12"><p><?php echo $signature ?></p></div><?php } ?>

        <!-- 스크랩 추천 비추천 시작 { -->
        <?php if ($scrap_href || $good_href || $nogood_href) { ?>

		<div class="row h4"><p class="hidden">한줄간격주기</p></div>

        <div id="bo_v_act" class="col-xs-12 text-center">
            <?php if ($scrap_href) { ?><a href="<?php echo $scrap_href;  ?>" target="_blank" class="btn btn-default" onclick="win_scrap(this.href); return false;">스크랩</a><?php } ?>
            <?php if ($good_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $good_href.'&amp;'.$qstr ?>" id="good_button" class="btn btn-default">추천 <b class="text-warning"><?php echo number_format($view['wr_good']) ?></b></a>
                <b id="bo_v_act_good"></b>
            </span>
            <?php } ?>
            <?php if ($nogood_href) { ?>
            <span class="bo_v_act_gng">
                <a href="<?php echo $nogood_href.'&amp;'.$qstr ?>" id="nogood_button" class="btn btn-default">비추천  <b class="text-warning"><?php echo number_format($view['wr_nogood']) ?></b></a>
                <b id="bo_v_act_nogood"></b>
            </span>
            <?php } ?>
        </div>
        <?php } else {
            if($board['bo_use_good'] || $board['bo_use_nogood']) {
        ?>
		<div class="row h4"><p class="hidden">한줄간격주기</p></div>

        <div id="bo_v_act" class="col-xs-12 text-center">
            <?php if($board['bo_use_good']) { ?><span>추천 <b class="text-warning"><?php echo number_format($view['wr_good']) ?></b></span><?php } ?>
            <?php if($board['bo_use_nogood']) { ?><span>비추천 <b class="text-warning"><?php echo number_format($view['wr_nogood']) ?></b></span><?php } ?>
        </div>
        <?php
            }
        }
        ?>
        <!-- } 스크랩 추천 비추천 끝 -->
    </div>

    <?php
    include_once($board_skin_path."/view.sns.skin.php");
    ?>

    <?php
    // 코멘트 입출력
    include_once(G5_BBS_PATH.'/view_comment.php');
     ?>

    <!-- 링크 버튼 시작 { -->
    <div id="bo_v_bot" class="col-xs-12 zero-padding">
        <?php echo $link_buttons ?>
    </div>
    <!-- } 링크 버튼 끝 -->

</div>
<!-- } 게시판 읽기 끝 -->

<script>
<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
        if(!g5_is_member) {
            alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
            return false;
        }

        var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

        if(confirm(msg)) {
            var href = $(this).attr("href")+"&js=on";
            $(this).attr("href", href);

            return true;
        } else {
            return false;
        }
    });
});
<?php } ?>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<script>
$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 추천, 비추천
    $("#good_button, #nogood_button").click(function() {
        var $tx;
        if(this.id == "good_button")
            $tx = $("#bo_v_act_good");
        else
            $tx = $("#bo_v_act_nogood");

        excute_good(this.href, $(this), $tx);
        return false;
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});

function excute_good(href, $el, $tx)
{
    $.post(
        href,
        { js: "on" },
        function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                if($tx.attr("id").search("nogood") > -1) {
                    $tx.text("이 글을 비추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                } else {
                    $tx.text("이 글을 추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                }
            }
        }, "json"
    );
}
</script>
<!-- } 게시글 읽기 끝 -->