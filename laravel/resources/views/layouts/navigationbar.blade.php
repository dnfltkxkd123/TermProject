<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<head>
  @yield('head')
	</head>
</head>
<body>
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <a class="navbar-brand" style='cursor:default'>ChanMin PHP</a>
      </div>
      <ul class="nav navbar-nav">
        <li class="active"><a href="main_page">Home</a></li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">추천책 <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="recommendBoard?thema=역사&page=1">역사</a></li>
              <li><a href="recommendBoard?thema=백과사전&page=1">백과사전</a></li>
              <li><a href="recommendBard?thema=철학&page=1">철학</a></li>
              <li><a href="recommendBoard?thema=종교&page=1">종교</a></li>
              <li><a href="recommendBoard?thema=사회과학&page=1">사회과학</a></li>
              <li><a href="recommendBoard?thema=자연과학&page=1">자연과학</a></li>
              <li><a href="recommendBoard?thema=기술과학&page=1">기술과학</a></li>
              <li><a href="recommendBoard?thema=예술&page=1">예술</a></li>
              <li><a href="recommendBoard?thema=어학&page=1">어학</a></li>
              <li><a href="recommendBoard?thema=문학&page=1">문학</a></li>
          </ul>
        </li>
        <li><a href="openBoard?page=1">자유게시판</a></li>
        <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="donateBook">도서기부<span class="caret"></span></a>
          <ul class='dropdown-menu'>
            <li><a href="donateBook?thema=역사&page=1">책받기</a></li>
            <li><a href="donateBook?thema=백과사전&page=1">주문한책</a></li>
            <li><a href="donateBook?thema=철학&page=1">주문받은책</a></li>
          </ul>
        </li>
      </ul>
      
      <form action='login?url=<?=$url?>&page=<?=$currentPage?>&num=<?=$num?>' method='post' enctype='multipart/form-data'>
        <ul class="nav navbar-nav navbar-right">
        <?php
          if($sessionOk){
            ?>
              <li><a><span class="glyphicon" style='cursor:default'><img class="avatar img-circle" src="<?=$img?>" / style='width:25px;height:25px;'> <?= $_SESSION['nickname']?>님 환영합니다.</span></a></li>
              <li><a href="logout"><span class="glyphicon glyphicon-log-out"></span> 로그아웃</a>
              </li>
              <li><a href="member_update_form?url=<?=$url?>&page=<?=$currentPage?>&num=<?=$num?>"><span class="glyphicon glyphicon-user"></span> 회원정보 수정</a></li>
            <?php
          }else{
            ?>
              <li>
                <a href="login_form?url=<?=$url?>&page=<?=$currentPage?>&num=<?=$num?>" id='login'><span class="glyphicon glyphicon-log-in"></span> 로그인</a>
              </li>
              <li><a href="register_form"><span class="glyphicon glyphicon-user"></span> 회원가입</a></li>
            
            <?php
          }
        ?>
      </ul>
    </form>
    </div>
  </nav>
  <div>
  	@yield('content')
  </div>
</body>
</html>