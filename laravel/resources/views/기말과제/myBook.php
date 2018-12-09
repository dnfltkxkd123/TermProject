<?php
  $url = 'donate_book.php';
  session_start();
  require('tools.php');
  require('memberDao.php');
  $sessionOk = sessionVar('id');
  $mdao = new MemberDao();
  if($sessionOk){
    $member = $mdao -> getMember($sessionOk);
    $img = $member['img'];
    if($img == null){
      $img = "http://www.tangoflooring.ca/wp-content/uploads/2015/07/user-avatar-placeholder.png";
    }
  }
  $loginOk = isset($_SESSION['id']);
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>jQuery Events</title>
    <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <script type="text/javascript" src="js/ajax.js"></script>
    <style>
        h1{
            text-align:center;
            margin-bottom:50px;
        }
        p{
            font-size:0.8em
        }
        ul{
            margin:0;
            padding:0;
        }
        li{
            list-style: none;
        }
        .box{
            margin:0 auto;
            max-width:1280px;
            
        }
        .l-row{
            width:100%;
            box-sizing: border-box;
        }
        .l-col{
            width:50%;
            margin-bottom:20px;
            float:left;
        }
        .editor{
            padding:10px;
        }
        .thema{
            border-top:solid 3px #088A68;
            margin-bottom:10px;
            /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#ffffff+1,f9f9f9+38,d8d8d8+99,6d6d6d+100 */
background: rgb(255,255,255); /* Old browsers */
background: -moz-linear-gradient(top, rgba(255,255,255,1) 1%, rgba(249,249,249,1) 38%, rgba(216,216,216,1) 99%, rgba(109,109,109,1) 100%); /* FF3.6-15 */
background: -webkit-linear-gradient(top, rgba(255,255,255,1) 1%,rgba(249,249,249,1) 38%,rgba(216,216,216,1) 99%,rgba(109,109,109,1) 100%); /* Chrome10-25,Safari5.1-6 */
background: linear-gradient(to bottom, rgba(255,255,255,1) 1%,rgba(249,249,249,1) 38%,rgba(216,216,216,1) 99%,rgba(109,109,109,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ffffff', endColorstr='#6d6d6d',GradientType=0 ); /* IE6-9 */
        }
        .thema span{
            color:#088A68;
            display:block;
            padding:10px;
            font-size:0.8em;
            font-weight: bold;
            position:relative;
            left:10px;
        }
        .editor-icon{
            float:left;
        }
        .editor-text{
            margin-left:158px;
            height:210px;
            overflow:hidden;
        }
        .wrap{
          float:left;  
        }
        .Watchlist{
            width:200px;
            float:left;  
            box-sizing: border-box;
            text-align: center;

        }
        .Watchlist li{
            width:105px;
            height:140px;
            margin-top:20px;
            margin-left:50px;
        }
        @media (max-width:685px){
          .l-col{
            width:100%;
          }
        }
    </style>
</head>
<body> 
    <?php
      require('navigationbar3.php');
    ?>
     <div class="box">
        <h1 class='header'>
            주문한책
         </h1>
        <div class="wrap">
            <ul class="l-row">
                <li class="l-col">
                    <div class="editor">
                        <div class='thema'>
                            <span>제목</span>
                        </div>
                        <img src="test.png" width='148px' height='210px' class="editor-icon"/>
                        <div class='editor-text'>
                            <div>
                                <h5>택배이름 : 준비중</h5>
                                <h5>운장번호 : 준비중</h5>
                            </div>
                            <br>
                            <time><p>등록일:2018-10-21</p></time>
                            <p><a href='recommend_book.php?page=<?=$currentPage?>'>Atom 1.27 brings numerous improvements to your Git and GitHub workflows, including support for multiple co-authors, separate amend and undo, a quicker way to open a pull request on github.com, as well as pulling and pushing directly from the status bar. Update today for a richer</a></p>
                        </div>
                    </div>
                </li>
                
                
            </ul>
            
        </div>
         
    </div>

</body>
</html>