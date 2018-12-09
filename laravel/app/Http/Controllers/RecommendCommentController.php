<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RecommendComment;

class RecommendCommentController extends Controller
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
		  RecommendComment::insertComment($num,$nickname,$text);
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
	  RecommendComment::updateComment($count,$text);
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
		RecommendComment::deleteComment(requestValue('count'));
		loginOk();
    }
}
