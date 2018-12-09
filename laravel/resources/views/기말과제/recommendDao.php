<?php

	class RecommendDao{
		private $db;
		public function __construct(){
			try{
				$this -> db = new PDO('mysql:host=localhost;dbname=assignment','root','');
				$this -> db -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				$this -> db -> exec('set names utf8');
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
		}

		public function insertData($nickname,$title,$img,$thema,$content){
			try{
				$ps = $this -> db -> prepare('insert into recommend_book(nickname,title,img,thema,content,date) value(:nickname,:title,:img,:thema,:content,now())');
				$ps -> bindValue(':nickname',$nickname,PDO::PARAM_STR);
				$ps -> bindValue(':title',$title,PDO::PARAM_STR);
				$ps -> bindValue(':img',$img,PDO::PARAM_STR);
				$ps -> bindValue(':thema',$thema,PDO::PARAM_STR);
				$ps -> bindValue(':content',$content,PDO::PARAM_STR);
				$ps -> execute();
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
		}

		public function getListCount($thema){
			try{
				$ps = $this -> db -> prepare('select count(*) from recommend_book where thema=:thema');
				$ps -> bindValue(':thema',$thema,PDO::PARAM_STR);
				$ps -> execute();
				$rs = $ps -> fetchColumn();
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
			return $rs;
		}

		public function getThemaData($thema){
			try{
				$ps = $this -> db -> prepare('select*from recommend_book where thema=:thema');
				$ps -> bindValue(':thema',$thema,PDO::PARAM_STR);
				$ps -> execute();
				$rs = $ps -> fetchAll(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
			return $rs;
		}

		public function getOnePageList($thema,$start,$row){
			try{
				$ps = $this -> db -> prepare('select*from recommend_book where thema=:thema order by date desc limit :start,:row');
				$ps -> bindValue(":thema",$thema,PDO::PARAM_STR);
				$ps -> bindValue(":start",$start,PDO::PARAM_INT);
				$ps -> bindValue(":row",$row,PDO::PARAM_INT);
				$ps -> execute();
				$rs = $ps -> fetchAll(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
			return $rs;

		}

		public function getRecommendData($num){
			try{
				$ps = $this -> db -> prepare('select*from recommend_book where num=:num');
				$ps -> bindValue(':num',$num,PDO::PARAM_INT);
				$ps -> execute();
				$rs = $ps -> fetch(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
			return $rs;
		}
	}
?>