<?php
	class ReplyCommentDao{
		private $db;
		private $table;
		function __construct($table){
			try{
				$this -> table = $table;
				$this -> db = new PDO('mysql:host=localhost;dbname=assignment','root','');
				$this -> db -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				$this -> db -> exec('set names utf8');
			}catch(PDOException $e){
				exit($e -> getMessage());
			}		
		}

		function insertReply($count,$text,$nickname){
			try{
				$table = $this->table;
				$ps = $this -> db -> prepare('insert into '.$table.'(count,text,date,nickname) value(:count,:text,now(),:nickname)');
				$ps -> bindValue(':count',$count,PDO::PARAM_INT);
				$ps -> bindValue(':text',$text,PDO::PARAM_STR);
				$ps -> bindValue(':nickname',$nickname,PDO::PARAM_STR);
				$ps -> execute();
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
		}

		function deleteReply($num){
			try{
				$table = $this->table;
				$ps = $this -> db -> prepare('delete from '.$table.' where num=:num');
				$ps -> bindValue(':num',$num,PDO::PARAM_INT);

				$ps -> execute();
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
		}

		function updateReply($num,$text){
			try{
				$table = $this->table;
				$ps = $this -> db -> prepare('update '.$table.' set text=:text where num=:num');
				$ps -> bindValue(':num',$num,PDO::PARAM_INT);
				$ps -> bindValue(':text',$text,PDO::PARAM_STR);
				$ps -> execute();
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
		}

		function getCount($count){
			try{
				$table = $this->table;
				$ps = $this -> db -> prepare('select count(*) from '.$table.' where count=:count');
				$ps -> bindValue(':count',$count,PDO::PARAM_INT);
				$ps -> execute();
				$rs = $ps -> fetchColumn();
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
			return $rs;
		}

		function getAllCount(){
			try{
				$table = $this->table;
				$ps = $this -> db -> prepare('select count(*) from '.$table);
				$ps -> execute();
				$rs = $ps -> fetchColumn();
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
			return $rs;
		}

		function getReply($count){
			try{
				$table = $this->table;
				$ps = $this -> db -> prepare('select*from '.$table.' where count=:count');
				$ps -> bindValue(':count',$count,PDO::PARAM_INT);
				$ps -> execute();
				$rs = $ps -> fetchAll(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
			return $rs;
		}

		function getReply2($num){
			try{
				$table = $this->table;
				$ps = $this -> db -> prepare('select*from '.$table.' where num=:num');
				$ps -> bindValue(':num',$num,PDO::PARAM_INT);
				$ps -> execute();
				$rs = $ps -> fetchAll(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
			return $rs;
		}

		function getReply3($limit){
			try{
				$table = $this->table;
				$ps = $this -> db -> prepare('select*from '.$table.' limit :limit'.',1');
				$ps -> bindValue(':limit',$limit,PDO::PARAM_INT);
				$ps -> execute();
				$rs = $ps -> fetchAll(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
			return $rs;
		}
	}
?>