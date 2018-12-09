<?php
	class CommentDao{
		private $db;
		private $table;
		public function __construct($table){
			try{
				$this -> table = $table;
				$this -> db = new PDO('mysql:host=localhost;dbname=assignment','root','');
				$this -> db -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				$this -> db -> exec('set names utf8');
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
		}

		public function insertComment($num,$nickname,$text){
			try{
				$table = $this -> table;
				$ps = $this -> db -> prepare('insert into '.$table.'(num,nickname,text,date) value(:num,:nickname,:text,now())');//comment '.$table.'
				$ps -> bindValue(":num",$num,PDO::PARAM_INT);
				$ps -> bindValue(":nickname",$nickname,PDO::PARAM_STR);
				$ps -> bindValue(":text",$text,PDO::PARAM_STR);
				$ps -> execute();
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
		}

		public function getCommentData($num){
			try{
				$table = $this -> table;
				$ps = $this -> db -> prepare('select*from '.$table.' where num=:num');//comment
				$ps -> bindValue(":num",$num,PDO::PARAM_INT);
				$ps -> execute();
				$rs = $ps -> fetchAll(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
			return $rs;
		}

		public function commentCount($num){
			try{
				$table = $this -> table;
				$ps = $this -> db -> prepare('select count(*) from '.$table.' where num=:num');//comment
				$ps -> bindValue(":num",$num,PDO::PARAM_INT);
				$ps -> execute();
				$rs = $ps -> fetchColumn();
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
			return $rs;
		}

		public function getOnePageList($num,$start , $row){
			try{
				$table = $this -> table;
				$ps = $this -> db -> prepare('select*from '.$table.' where num=:num order by date desc limit :start,:row');//comment
				$ps -> bindValue(":num",$num,PDO::PARAM_INT);
				$ps -> bindValue(":start",$start,PDO::PARAM_INT);
				$ps -> bindValue(":row",$row,PDO::PARAM_INT);
				$ps -> execute();
				$rs = $ps -> fetchAll(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
			return $rs;
		}

		public function delete($count){
			try{
				$table = $this -> table;
				$ps = $this -> db -> prepare('delete from '.$table.' where count=:count');//comment
				$ps -> bindValue(':count',$count,PDO::PARAM_INT);
				$ps -> execute();
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
		}

		public function updateComment($count,$text){
			try{
				$table = $this -> table;
				$ps = $this -> db -> prepare('update '.$table.' set text=:text where count=:count');//comment
				$ps -> bindValue(":count",$count,PDO::PARAM_INT);
				$ps -> bindValue(":text",$text,PDO::PARAM_STR);
				$ps -> execute();
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
		}


	}
	/*
	class CommentDao{
		private $db;
		private $table;
		public function __construct(){
			try{

				$this -> db = new PDO('mysql:host=localhost;dbname=assignment','root','');
				$this -> db -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				$this -> db -> exec('set names utf8');
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
		}

		public function insertComment($num,$nickname,$text){
			try{

				$ps = $this -> db -> prepare('insert into comment(num,nickname,text,date) value(:num,:nickname,:text,now())');//comment '.$tname.'
				$ps -> bindValue(":num",$num,PDO::PARAM_INT);
				$ps -> bindValue(":nickname",$nickname,PDO::PARAM_STR);
				$ps -> bindValue(":text",$text,PDO::PARAM_STR);
				$ps -> execute();
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
		}

		public function getCommentData($num){
			try{

				$ps = $this -> db -> prepare('select*from comment where num=:num');//comment
				$ps -> bindValue(":num",$num,PDO::PARAM_INT);
				$ps -> execute();
				$rs = $ps -> fetchAll(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
			return $rs;
		}

		public function commentCount($num){
			try{
	
				$ps = $this -> db -> prepare('select count(*) from comment where num=:num');//comment
				$ps -> bindValue(":num",$num,PDO::PARAM_INT);
				$ps -> execute();
				$rs = $ps -> fetchColumn();
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
			return $rs;
		}

		public function getOnePageList($num,$start , $row){
			try{
		
				$ps = $this -> db -> prepare('select*from comment where num=:num order by date desc limit :start,:row');//comment
				$ps -> bindValue(":num",$num,PDO::PARAM_INT);
				$ps -> bindValue(":start",$start,PDO::PARAM_INT);
				$ps -> bindValue(":row",$row,PDO::PARAM_INT);
				$ps -> execute();
				$rs = $ps -> fetchAll(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
			return $rs;
		}

		public function delete($count){
			try{
	
				$ps = $this -> db -> prepare('delete from comment where count=:count');//comment
				$ps -> bindValue(':count',$count,PDO::PARAM_INT);
				$ps -> execute();
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
		}

	}
	*/
?>