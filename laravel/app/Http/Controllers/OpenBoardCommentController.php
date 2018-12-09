<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OpenBoardComment;

class OpenBoardCommentController extends Controller
{
    //
    public function insertComment(){
    	session_start();
		  require('tool.php');
		  $nickname = sessionVar('nickname');
		  $num = requestValue('num');
		  $text = requestValue('text');
		  $text = nl2br($text);
		  $table = requestValue('table');
		  OpenBoardComment::insertComment($num,$nickname,$text);
		  loginOk();
		  ?>
		  <!DOCTYPE html>
		  <html lang="en">
		  <head>
		    <meta charset="UTF-8">
		    <title>Document</title>
		  </head>
		  <body>
		    <script>
		      history.back();
		    </script>
		  </body>
		  </html>
		  <?php
    }

    public function updateComment(){
    	session_start();
	  require('tool.php');
	  $nickname = sessionVar('nickname');
	  $url = requestValue('url');
	  $page = requestValue('page');
	  $count = requestValue('count');
	  $text = requestValue('text');
	  $text = nl2br($text);
	  $table = requestValue('table');
	  OpenBoardComment::updateComment($count,$text);
	  ?>
	  <!DOCTYPE html>
	  <html lang="en">
	  <head>
	    <meta charset="UTF-8">
	    <title>Document</title>
	  </head>
	  <body>
	    <script>
	      history.back();
	    </script>
	  </body>
	  </html>
	  <?php

    }

     public function deleteComment(){
     	require('tool.php');
		OpenBoardComment::deleteComment(requestValue('count'));
		loginOk();
    }


}
