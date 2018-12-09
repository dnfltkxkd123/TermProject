<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 스킨 함수
@include_once($board_skin_path.'/skin.common.lib.php');

// 분류 사용 여부
$is_category = false;
$category_option = '';
if ($board['bo_use_category']) {
    $is_category = true;
    $category_href = G5_BBS_URL.'/board.php?bo_table='.$bo_table;

    $category_option .= '<li';
    if ($sca=='')
        $category_option .= ' class="active"';
	$category_option .= '><a href="'.$category_href.'">전체</a></li>';

    $categories = explode('|', $board['bo_category_list']); // 구분자가 , 로 되어 있음
    for ($i=0; $i<count($categories); $i++) {
        $category = trim($categories[$i]);
        if ($category=='') continue;
        $category_option .= '<li';
        if ($category==$sca) { // 현재 선택된 카테고리라면
            $category_option .= ' class="active"';
        }
		$category_option .= '><a href="'.($category_href."&amp;sca=".urlencode($category)).'">'.$category.'</a></li>';
    }
}

// 페이징 다시 만들기
$write_pages = get_paging_overriding(G5_IS_MOBILE ? $config['cf_mobile_pages'] : $config['cf_write_pages'], $page, $total_page, './board.php?bo_table='.$bo_table.$qstr.'&amp;page=');
$write_pages_mobile = get_paging_overriding($config['cf_mobile_pages'], $page, $total_page, './board.php?bo_table='.$bo_table.$qstr.'&amp;page=');

// 선택옵션으로 인해 셀합치기가 가변적으로 변함
$colspan = 5;

if ($is_checkbox) $colspan++;
if ($is_good) $colspan++;
if ($is_nogood) $colspan++;

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>
<div class="col-xs-12">
	<h3 id="container_title"><?php echo $board['bo_subject'] ?><span class="sr-only sound_only"> 목록</span></h3>
</div>

<!-- 게시판 목록 시작 { -->
<div class="col-xs-12">

    <!-- 게시판 카테고리 시작 { -->
    <?php if ($is_category) { ?>
		<ul class="nav nav-pills h5">
			<?php echo $category_option ?>
		</ul>
	<?php } ?>
    <!-- } 게시판 카테고리 끝 -->

    <!-- 게시판 페이지 정보 및 버튼 시작 { -->
    <div class="col-xs-12 zero-padding">

        <div id="bo_list_total" class="pull-left h4">
			<div class="hidden-xs h5">
				<span>Total <?php echo number_format($total_count) ?>건</span>
				<?php echo $page ?> 페이지
			</div>
			<div class="hidden visible-xs h5">
				<span>T : <?php echo number_format($total_count) ?> / </span>
				P : <?php echo $page ?>
			</div>
        </div>

        <?php if ($rss_href || $write_href) { ?>
        <ul class="list-inline pull-right h5">
            <?php if ($rss_href) { ?><li class="zero-padding"><a href="<?php echo $rss_href ?>" class="btn btn-warning link-btn">RSS</a></li><?php } ?>
            <?php if ($admin_href) { ?><li class="zero-padding"><a href="<?php echo $admin_href ?>" class="btn btn-danger link-btn">관리자</a></li><?php } ?>
            <?php if ($write_href) { ?><li class="zero-padding"><a href="<?php echo $write_href ?>" class="btn btn-primary link-btn">글쓰기</a></li><?php } ?>
        </ul>
        <?php } ?>

    </div>
    <!-- } 게시판 페이지 정보 및 버튼 끝 -->

    <form name="fboardlist" id="fboardlist" action="./board_list_update.php" onsubmit="return fboardlist_submit(this);" method="post" role="form">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sfl" value="<?php echo $sfl ?>">
    <input type="hidden" name="stx" value="<?php echo $stx ?>">
    <input type="hidden" name="spt" value="<?php echo $spt ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sst" value="<?php echo $sst ?>">
    <input type="hidden" name="sod" value="<?php echo $sod ?>">
    <input type="hidden" name="page" value="<?php echo $page ?>">
    <input type="hidden" name="sw" value="">

    <div class="col-xs-12 zero-padding">
        <table class="table table-hover text-center bottom-3b">
        <caption class="sr-only"><?php echo $board['bo_subject'] ?> 목록</caption>
        <thead>
        <tr class="bg-primary">
            <th scope="col" class="text-center w60">번호</th>
            <?php if ($is_checkbox) { ?>
            <th scope="col" class="text-center w30">
                <label for="chkall" class="sr-only sound_only">현재 페이지 게시물 전체</label>
                <input type="checkbox" id="chkall" onclick="if (this.checked) all_checked(true); else all_checked(false);" class="checkbox-middle">
            </th>
            <?php } ?>
            <th scope="col" class="text-center">제목</th>
            <th scope="col" class="hidden visible-lg text-center w100">글쓴이</th>
            <th scope="col" class="hidden visible-lg text-center w90"><?php echo subject_sort_link_overriding('wr_datetime', $qstr2, 1) ?>날짜</a></th>
            <th scope="col" class="hidden visible-lg text-center w60"><?php echo subject_sort_link_overriding('wr_hit', $qstr2, 1) ?>조회</a></th>
            <?php if ($is_good) { ?><th scope="col" class="hidden visible-lg text-center w60"><?php echo subject_sort_link_overriding('wr_good', $qstr2, 1) ?>추천</a></th><?php } ?>
            <?php if ($is_nogood) { ?><th scope="col" class="hidden visible-lg text-center w60"><?php echo subject_sort_link_overriding('wr_nogood', $qstr2, 1) ?>비추천</a></th><?php } ?>
        </tr>
        </thead>
        <tbody>
        <?php
        for ($i=0; $i<count($list); $i++) {
			
			// 글쓴이 이름 사이드뷰
			$tmp_name = get_text(cut_str($list[$i]['wr_name'], $config['cf_cut_name'])); // 설정된 자리수 만큼만 이름 출력
			$tmp_name2 = cut_str($list[$i]['wr_name'], $config['cf_cut_name']); // 설정된 자리수 만큼만 이름 출력
			if ($board['bo_use_sideview'])
				$list[$i]['name'] = get_sideview_overriding($list[$i]['mb_id'], $tmp_name2, $list[$i]['wr_email'], $list[$i]['wr_homepage']);
			else
				$list[$i]['name'] = '<span class="'.($list[$i]['mb_id']?'sv_member':'sv_guest').'">'.$tmp_name.'</span>';

         ?>
        <tr class="<?php if ($list[$i]['is_notice']) echo "bo_notice"; ?>">
            <td class="td_num text-center">
            <?php
            if ($list[$i]['is_notice']) // 공지사항
                echo '<b>공지</b>';
            else if ($wr_id == $list[$i]['wr_id'])
                echo "<span class=\"text-danger\">열람중</span>";
            else
                echo $list[$i]['num'];
             ?>
            </td>
            <?php if ($is_checkbox) { ?>
            <td class="td_chk text-center">
                <label for="chk_wr_id_<?php echo $i ?>" class="sr-only sound_only"><?php echo $list[$i]['subject'] ?></label>
                <input type="checkbox" name="chk_wr_id[]" value="<?php echo $list[$i]['wr_id'] ?>" id="chk_wr_id_<?php echo $i ?>">
            </td>
            <?php } ?>
            <td class="td_subject text-left">
                <?php
                echo $list[$i]['icon_reply'];
                if ($is_category && $list[$i]['ca_name']) {
                 ?>
                <a href="<?php echo $list[$i]['ca_name_href'] ?>" class="label label-primary link-inverse"><?php echo $list[$i]['ca_name'] ?></a>
                <?php } ?>

                <a href="<?php echo $list[$i]['href'] ?>">
                    <?php echo $list[$i]['subject'] ?>
                    <?php if ($list[$i]['comment_cnt']) { ?><span class="sr-only sound_only">댓글</span><b><small class="text-danger"><?php echo $list[$i]['comment_cnt']; ?></small></b><span class="sr-only sound_only">개</span><?php } ?>
                </a>

                <?php
                // if ($list[$i]['link']['count']) { echo '['.$list[$i]['link']['count']}.']'; }
                // if ($list[$i]['file']['count']) { echo '<'.$list[$i]['file']['count'].'>'; }

                if (isset($list[$i]['icon_new'])) echo " " . $list[$i]['icon_new'];
                if (isset($list[$i]['icon_hot'])) echo " " . $list[$i]['icon_hot'];
                if (isset($list[$i]['icon_file'])) echo " " . $list[$i]['icon_file'];
                if (isset($list[$i]['icon_link'])) echo " " . $list[$i]['icon_link'];
                if (isset($list[$i]['icon_secret'])) echo " " . $list[$i]['icon_secret'];

                 ?>
				<div class="row h1 hidden-lg"><p class="hidden">한줄간격주기</p></div>
				<ul class="list-inline hidden-lg">
					<li><i class="fa fa-fw fa-user"></i><?php echo $list[$i]['name'] ?></li>
					<li><i class="fa fa-fw fa-calendar"></i><?php echo $list[$i]['datetime2'] ?></li>
					<li><i class="fa fa-fw fa-eye"></i><?php echo $list[$i]['wr_hit'] ?></li>
					<?php if ($is_good) { ?><li><i class="fa fa-fw fa-thumbs-up"></i><?php echo $list[$i]['wr_good'] ?></li><?php } ?>
					<?php if ($is_nogood) { ?><li><i class="fa fa-fw fa-thumbs-down"></i><?php echo $list[$i]['wr_nogood'] ?></li><?php } ?>
				</ul>
            </td>
            <td class="td_name sv_use hidden visible-lg text-center"><?php echo $list[$i]['name'] ?></td>
            <td class="td_date  hidden visible-lg text-center"><?php echo $list[$i]['datetime2'] ?></td>
            <td class="td_num  hidden visible-lg text-center"><?php echo $list[$i]['wr_hit'] ?></td>
            <?php if ($is_good) { ?><td class="td_num  hidden visible-lg text-center"><?php echo $list[$i]['wr_good'] ?></td><?php } ?>
            <?php if ($is_nogood) { ?><td class="td_num  hidden visible-lg text-center"><?php echo $list[$i]['wr_nogood'] ?></td><?php } ?>
        </tr>
        <?php } ?>
        <?php if (count($list) == 0) { echo '<tr><td colspan="'.$colspan.'" class="empty_table text-center">게시물이 없습니다.</td></tr>'; } ?>
        </tbody>
        </table>
    </div>

    <?php if ($list_href || $is_checkbox || $write_href) { ?>
    <div class="col-xs-12 zero-padding">
        <?php if ($is_checkbox) { ?>
		<ul class="btn_bo_adm list-inline pull-left">
            <li class="zero-padding"><button type="submit" name="btn_submit" value="선택삭제" onclick="document.pressed=this.value" class="btn btn-danger link-btn" title="선택삭제"><i class="fa fa-fw fa-trash"></i><span class="hidden-xs">선택삭제</span></button></li>
            <li class="zero-padding"><button type="submit" name="btn_submit" value="선택복사" onclick="document.pressed=this.value" class="btn btn-danger link-btn" title="선택복사"><i class="fa fa-fw fa-copy"></i><span class="hidden-xs">선택복사</span></button></li>
            <li class="zero-padding"><button type="submit" name="btn_submit" value="선택이동" onclick="document.pressed=this.value" class="btn btn-danger link-btn" title="선택이동"><i class="fa fa-fw fa-share-square-o"></i><span class="hidden-xs">선택이동</span></button></li>
        </ul>
        <?php } ?>

        <?php if ($list_href || $write_href) { ?>
        <ul class="btn_bo_user list-inline pull-right">
            <?php if (!$list_href) { ?><li class="zero-padding"><a href="<?php echo $list_href ?>" class="btn btn-default">목록</a></li><?php } ?>
            <?php if ($write_href) { ?><li class="zero-padding"><a href="<?php echo $write_href ?>" class="btn btn-primary link-btn">글쓰기</a></li><?php } ?>
        </ul>
        <?php } ?>
    </div>
    <?php } ?>

    </form>
</div>

<?php if($is_checkbox) { ?>
<noscript>
<p>자바스크립트를 사용하지 않는 경우<br>별도의 확인 절차 없이 바로 선택삭제 처리하므로 주의하시기 바랍니다.</p>
</noscript>
<?php } ?>

<!-- 페이지 -->
<div class="hidden-xs">
<?php echo $write_pages;  ?>
</div>
<div class="hidden visible-xs">
<?php echo $write_pages_mobile;  ?>
</div>

<!-- 게시판 검색 시작 { -->
<div class="col-xs-12 text-center">
<fieldset id="bo_sch">
    <legend class="sr-only">게시물 검색</legend>

    <form name="fsearch" method="get" class="form-inline">
    <input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
    <input type="hidden" name="sca" value="<?php echo $sca ?>">
    <input type="hidden" name="sop" value="and">
	<div class="form-group">
		<label for="sfl" class="sr-only sound_only">검색대상</label>
		<select name="sfl" id="sfl" class="form-control">
			<option value="wr_subject"<?php echo get_selected($sfl, 'wr_subject', true); ?>>제목</option>
			<option value="wr_content"<?php echo get_selected($sfl, 'wr_content'); ?>>내용</option>
			<option value="wr_subject||wr_content"<?php echo get_selected($sfl, 'wr_subject||wr_content'); ?>>제목+내용</option>
			<option value="mb_id,1"<?php echo get_selected($sfl, 'mb_id,1'); ?>>회원아이디</option>
			<option value="mb_id,0"<?php echo get_selected($sfl, 'mb_id,0'); ?>>회원아이디(코)</option>
			<option value="wr_name,1"<?php echo get_selected($sfl, 'wr_name,1'); ?>>글쓴이</option>
			<option value="wr_name,0"<?php echo get_selected($sfl, 'wr_name,0'); ?>>글쓴이(코)</option>
		</select>
	</div>

	<div class="form-group">
		<label for="stx" class="sr-only sound_only">검색어<b class="sound_only"> 필수</b></label>
		<input type="text" name="stx" value="<?php echo stripslashes($stx) ?>" required id="stx" class="frm_input required form-control" size="15" maxlength="20">
	</div>

	<div class="form-group">
		<input type="submit" value="검색" class="btn btn-block btn-default">
	</div>
    </form>
</fieldset>
</div>
<!-- } 게시판 검색 끝 -->

<?php if ($is_checkbox) { ?>
<script>
function all_checked(sw) {
    var f = document.fboardlist;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]")
            f.elements[i].checked = sw;
    }
}

function fboardlist_submit(f) {
    var chk_count = 0;

    for (var i=0; i<f.length; i++) {
        if (f.elements[i].name == "chk_wr_id[]" && f.elements[i].checked)
            chk_count++;
    }

    if (!chk_count) {
        alert(document.pressed + "할 게시물을 하나 이상 선택하세요.");
        return false;
    }

    if(document.pressed == "선택복사") {
        select_copy("copy");
        return;
    }

    if(document.pressed == "선택이동") {
        select_copy("move");
        return;
    }

    if(document.pressed == "선택삭제") {
        if (!confirm("선택한 게시물을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다\n\n답변글이 있는 게시글을 선택하신 경우\n답변글도 선택하셔야 게시글이 삭제됩니다."))
            return false;

        f.removeAttribute("target");
        f.action = "./board_list_update.php";
    }

    return true;
}

// 선택한 게시물 복사 및 이동
function select_copy(sw) {
    var f = document.fboardlist;

    if (sw == "copy")
        str = "복사";
    else
        str = "이동";

    var sub_win = window.open("", "move", "left=50, top=50, width=500, height=550, scrollbars=1");

    f.sw.value = sw;
    f.target = "move";
    f.action = "./move.php";
    f.submit();
}
</script>
<?php } ?>
<!-- } 게시판 목록 끝 -->
