<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// 스킨 공통 함수
@include_once($board_skin_path.'/skin.common.lib.php');

// 썸머노트를 에디터로 지정
$config['cf_editor'] = 'summernote_1_3';

$captcha_html = '';
if ($is_guest) {
    $captcha_html = captcha_html_overriding();
}

$is_dhtml_editor = false;
$is_dhtml_editor_use = false;
$editor_content_js = '';
if(!is_mobile() || defined('G5_IS_MOBILE_DHTML_USE') && G5_IS_MOBILE_DHTML_USE)
    $is_dhtml_editor_use = true;

// 모바일에서는 G5_IS_MOBILE_DHTML_USE 설정에 따라 DHTML 에디터 적용
if ($config['cf_editor'] && $is_dhtml_editor_use && $board['bo_use_dhtml_editor'] && $member['mb_level'] >= $board['bo_html_level']) {
    $is_dhtml_editor = true;

    if(is_file(G5_EDITOR_PATH.'/'.$config['cf_editor'].'/autosave.editor.js'))
        $editor_content_js = '<script src="'.G5_EDITOR_URL.'/'.$config['cf_editor'].'/autosave.editor.js"></script>'.PHP_EOL;
}

$editor_html = editor_html_overriding('wr_content', $content, $is_dhtml_editor);
$editor_js = '';
$editor_js .= get_editor_js_overriding('wr_content', $is_dhtml_editor);
$editor_js .= chk_editor_js_overriding('wr_content', $is_dhtml_editor);

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
// add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<div id="bo_w" class="col-xs-12">

	<div class="panel panel-default">

		<div class="panel-heading"><h4 id="container_title" class="panel-title"><b><?php echo $g5['title'] ?></b></h4></div>

		<!-- 게시물 작성/수정 시작 { -->
		<form name="fwrite" id="fwrite" action="<?php echo $action_url ?>" onsubmit="return fwrite_submit(this);" method="post" enctype="multipart/form-data" autocomplete="off" style="width:<?php echo $width; ?>" role="form">
		<input type="hidden" name="uid" value="<?php echo get_uniqid(); ?>">
		<input type="hidden" name="w" value="<?php echo $w ?>">
		<input type="hidden" name="bo_table" value="<?php echo $bo_table ?>">
		<input type="hidden" name="wr_id" value="<?php echo $wr_id ?>">
		<input type="hidden" name="sca" value="<?php echo $sca ?>">
		<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
		<input type="hidden" name="stx" value="<?php echo $stx ?>">
		<input type="hidden" name="spt" value="<?php echo $spt ?>">
		<input type="hidden" name="sst" value="<?php echo $sst ?>">
		<input type="hidden" name="sod" value="<?php echo $sod ?>">
		<input type="hidden" name="page" value="<?php echo $page ?>">
		<?php
		$option = '';
		$option_hidden = '';
		if ($is_notice || $is_html || $is_secret || $is_mail) {
			$option = '';
			if ($is_notice) {
				$option .= "\n".'<input type="checkbox" id="notice" name="notice" value="1" '.$notice_checked.'>'."\n".'<label for="notice">공지</label>';
			}

			if ($is_html) {
				if ($is_dhtml_editor) {
					$option_hidden .= '<input type="hidden" value="html1" name="html">';
				} else {
					$option .= "\n".'<input type="checkbox" id="html" name="html" onclick="html_auto_br(this);" value="'.$html_value.'" '.$html_checked.'>'."\n".'<label for="html">html</label>';
				}
			}

			if ($is_secret) {
				if ($is_admin || $is_secret==1) {
					$option .= "\n".'<input type="checkbox" id="secret" name="secret" value="secret" '.$secret_checked.'>'."\n".'<label for="secret">비밀글</label>';
				} else {
					$option_hidden .= '<input type="hidden" name="secret" value="secret">';
				}
			}

			if ($is_mail) {
				$option .= "\n".'<input type="checkbox" id="mail" name="mail" value="mail" '.$recv_email_checked.'>'."\n".'<label for="mail">답변메일받기</label>';
			}
		}

		echo $option_hidden;
		?>

		<div class="panel-body">
			<table class="table">
			<tbody>
			<?php if ($is_name) { ?>
			<tr>
				<th scope="row" class="w120 hidden-xs"><label for="wr_name" class="control-label">이름<b class="sr-only sound_only">필수</b></label></th>
				<td><p class="hidden visible-xs"><label for="wr_name" class="control-label">이름<b class="sr-only sound_only">필수</b></label></p><div class="col-sm-3 zero-padding"><input type="text" name="wr_name" value="<?php echo $name ?>" id="wr_name" required class="frm_input required form-control" size="10" maxlength="20"></div></td>
			</tr>
			<?php } ?>

			<?php if ($is_password) { ?>
			<tr>
				<th scope="row" class="w120 hidden-xs"><label for="wr_password" class="control-label">비밀번호<b class="sr-only sound_only">필수</b></label></th>
				<td><p class="hidden visible-xs"><label for="wr_password" class="control-label">비밀번호<b class="sr-only sound_only">필수</b></label></p><div class="col-sm-3 zero-padding"><input type="password" name="wr_password" id="wr_password" <?php echo $password_required ?> class="frm_input <?php echo $password_required ?> form-control" maxlength="20"></div></td>
			</tr>
			<?php } ?>

			<?php if ($is_email) { ?>
			<tr>
				<th scope="row" class="w120 hidden-xs"><label for="wr_email" class="control-label">이메일</label></th>
				<td><p class="hidden visible-xs"><label for="wr_email" class="control-label">이메일</label></p><div class="col-sm-6 zero-padding"><input type="text" name="wr_email" value="<?php echo $email ?>" id="wr_email" class="frm_input email form-control" size="50" maxlength="100"></div></td>
			</tr>
			<?php } ?>

			<?php if ($is_homepage) { ?>
			<tr>
				<th scope="row" class="w120 hidden-xs"><label for="wr_homepage" class="control-label">홈페이지</label></th>
				<td><p class="hidden visible-xs"><label for="wr_homepage" class="control-label">홈페이지</label></p><div class="col-sm-6 zero-padding"><input type="text" name="wr_homepage" value="<?php echo $homepage ?>" id="wr_homepage" class="frm_input form-control" size="50"></div></td>
			</tr>
			<?php } ?>

			<?php if ($option) { ?>
			<tr>
				<th scope="row" class="w120 hidden-xs"><label class="control-label">옵션</label></th>
				<td><p class="hidden visible-xs"><label class="control-label">옵션</label></p><?php echo $option ?></td>
			</tr>
			<?php } ?>

			<?php if ($is_category) { ?>
			<tr>
				<th scope="row" class="w120 hidden-xs"><label for="ca_name" class="control-label">분류<b class="sr-only sound_only">필수</b></label></th>
				<td>
				
					<p class="hidden visible-xs"><label for="ca_name" class="control-label">분류<b class="sr-only sound_only">필수</b></label></p>

					<select name="ca_name" id="ca_name" required class="required form-control" >
						<option value="">선택하세요</option>
						<?php echo $category_option ?>
					</select>
				</td>
			</tr>
			<?php } ?>

			<tr>
				<th scope="row" class="w120 hidden-xs"><label for="wr_subject" class="control-label">제목<b class="sr-only sound_only">필수</b></label></th>
				<td>

					<p class="hidden visible-xs"><label for="wr_subject" class="control-label">제목<b class="sr-only sound_only">필수</b></label></p>						

					<div id="autosave_wrapper" class="col-sm-12 zero-padding">
						
						<div class="input-group">

							<input type="text" name="wr_subject" value="<?php echo $subject ?>" id="wr_subject" required class="frm_input required form-control" size="50" maxlength="255">
						
							<?php if ($is_member) { // 임시 저장된 글 기능 ?>

							<script src="<?php echo $board_skin_url; ?>/autosave.js"></script>

							<?php if($editor_content_js) echo $editor_content_js; ?>

							<div class="input-group-btn">

								<button type="button" id="btn_autosave" class="btn btn-default dropdown-toggle" data-toggle="dropdown"><i class="fa fa-save"></i><span class="hidden-xs"> 임시 저장된 글</span> (<span id="autosave_count"><?php echo $autosave_count; ?></span>) <span class="fa fa-caret-down"></span></button>

								<div id="autosave_pop" class="dropdown-menu dropdown-menu-right" role="menu">
									<b class="sr-only">임시 저장된 글 목록</b>
									<div class="text-right"><a type="button" class="autosave_close"><img src="<?php echo $board_skin_url; ?>/img/btn_close.gif" alt="닫기"></a>&nbsp;&nbsp;</div>
									<ul class="list-unstyled"></ul>
									<div class="text-right"><a type="button" class="autosave_close"><img src="<?php echo $board_skin_url; ?>/img/btn_close.gif" alt="닫기"></a>&nbsp;&nbsp;</div>
								</div>

							</div><!-- end input-group-btn -->

							<?php } ?>
						</div>
					</div>
				</td>
			</tr>

			<tr>
				<th scope="row" class="w120 hidden-xs"><label for="wr_content" class="control-label">내용<b class="sr-only sound_only">필수</b></label></th>
				<td class="wr_content">

					<p class="hidden visible-xs"><label for="wr_content" class="control-label">내용<b class="sr-only sound_only">필수</b></label></p>

					<?php if($write_min || $write_max) { ?>
					<!-- 최소/최대 글자 수 사용 시 -->
					<p id="char_count_desc">이 게시판은 최소 <b><?php echo $write_min; ?></b>글자 이상, 최대 <b><?php echo $write_max; ?></b>글자 이하까지 글을 쓰실 수 있습니다.</p>
					<?php } ?>
					<?php echo $editor_html; // 에디터 사용시는 에디터로, 아니면 textarea 로 노출 ?>
					<?php if($write_min || $write_max) { ?>
					<!-- 최소/최대 글자 수 사용 시 -->
					<div id="char_count_wrap"><span id="char_count"></span>글자</div>
					<?php } ?>
				</td>
			</tr>

			<?php for ($i=1; $is_link && $i<=G5_LINK_COUNT; $i++) { ?>
			<tr>
				<th scope="row" class="w120 hidden-xs"><label for="wr_link<?php echo $i ?>" class="control-label">링크 #<?php echo $i ?></label></th>
				<td><p class="hidden visible-xs"><label for="wr_link<?php echo $i ?>" class="control-label">링크 #<?php echo $i ?></label></p><input type="text" name="wr_link<?php echo $i ?>" value="<?php if($w=="u"){echo$write['wr_link'.$i];} ?>" id="wr_link<?php echo $i ?>" class="frm_input form-control" size="50"></td>
			</tr>
			<?php } ?>

			<?php for ($i=0; $is_file && $i<$file_count; $i++) { ?>
			<tr>
				<th scope="row" class="w120 hidden-xs"><label class="control-label">파일 #<?php echo $i+1 ?></label></th>
				<td>

					<p class="hidden visible-xs"><label class="control-label">파일 #<?php echo $i+1 ?></label></p>

					<input type="file" name="bf_file[]" title="파일첨부 <?php echo $i+1 ?> : 용량 <?php echo $upload_max_filesize ?> 이하만 업로드 가능" class="frm_file frm_input form-control">

					<?php if ($is_file_content) { ?>					
					<input type="text" name="bf_content[]" value="<?php echo ($w == 'u') ? $file[$i]['bf_content'] : ''; ?>" title="파일 설명을 입력해주세요." class="frm_file frm_input form-control" size="50">					
					<?php } ?>

					<?php if($w == 'u' && $file[$i]['file']) { ?>
					<input type="checkbox" id="bf_file_del<?php echo $i ?>" name="bf_file_del[<?php echo $i;  ?>]" value="1"> <label for="bf_file_del<?php echo $i ?>"><?php echo $file[$i]['source'].'('.$file[$i]['size'].')';  ?> 파일 삭제</label>
					<?php } ?>

				</td>
			</tr>
			<?php } ?>

			<?php if ($is_guest) { //자동등록방지  ?>
			<tr>
				<th scope="row" class="w120 hidden-xs"><label for="captcha_key" class="control-label">자동등록방지</label></th>
				<td>

					<p class="hidden visible-xs"><label for="captcha_key" class="control-label">자동등록방지</label></p>

					<?php echo $captcha_html ?>
				</td>
			</tr>
			<?php } ?>

			</tbody>
			</table>
		</div>

		<div class="btn_confirm panel-footer text-center">
			<input type="submit" value="작성완료" id="btn_submit" accesskey="s" class="btn_submit btn btn-danger">
			<a href="./board.php?bo_table=<?php echo $bo_table ?>" class="btn_cancel btn btn-default">취소</a>
		</div>
		</form>

		<script>
		<?php if($write_min || $write_max) { ?>
		// 글자수 제한
		var char_min = parseInt(<?php echo $write_min; ?>); // 최소
		var char_max = parseInt(<?php echo $write_max; ?>); // 최대
		check_byte("wr_content", "char_count");

		$(function() {
			$("#wr_content").on("keyup", function() {
				check_byte("wr_content", "char_count");
			});
		});

		<?php } ?>
		function html_auto_br(obj)
		{
			if (obj.checked) {
				result = confirm("자동 줄바꿈을 하시겠습니까?\n\n자동 줄바꿈은 게시물 내용중 줄바뀐 곳을<br>태그로 변환하는 기능입니다.");
				if (result)
					obj.value = "html2";
				else
					obj.value = "html1";
			}
			else
				obj.value = "";
		}

		function fwrite_submit(f)
		{
			<?php echo $editor_js; // 에디터 사용시 자바스크립트에서 내용을 폼필드로 넣어주며 내용이 입력되었는지 검사함   ?>

			var subject = "";
			var content = "";
			$.ajax({
				url: g5_bbs_url+"/ajax.filter.php",
				type: "POST",
				data: {
					"subject": f.wr_subject.value,
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

			if (subject) {
				alert("제목에 금지단어('"+subject+"')가 포함되어있습니다");
				f.wr_subject.focus();
				return false;
			}

			if (content) {
				alert("내용에 금지단어('"+content+"')가 포함되어있습니다");
				if (typeof(ed_wr_content) != "undefined")
					ed_wr_content.returnFalse();
				else
					f.wr_content.focus();
				return false;
			}

			if (document.getElementById("char_count")) {
				if (char_min > 0 || char_max > 0) {
					var cnt = parseInt(check_byte("wr_content", "char_count"));
					if (char_min > 0 && char_min > cnt) {
						alert("내용은 "+char_min+"글자 이상 쓰셔야 합니다.");
						return false;
					}
					else if (char_max > 0 && char_max < cnt) {
						alert("내용은 "+char_max+"글자 이하로 쓰셔야 합니다.");
						return false;
					}
				}
			}

			<?php echo $captcha_js; // 캡챠 사용시 자바스크립트에서 입력된 캡챠를 검사함  ?>

			document.getElementById("btn_submit").disabled = "disabled";

			return true;
		}
		</script>
	</div>
</div>
<!-- } 게시물 작성/수정 끝 -->