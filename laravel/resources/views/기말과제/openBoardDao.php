<?php
	class OpenBoardDao{
		private $db;
		public function __construct(){
			try{
				$this -> db = new PDO('mysql:host=localhost;dbname=assignment','root','');
				$this -> db -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				$this -> db -> exec('set names utf8');
			}catch(PDOExcpetion $e){
				exit($e -> getMessage());
			}
		}

		public function insertData($title,$nickname,$text){
			try{
				$ps = $this -> db -> prepare("insert into openboard(title,nickname,text,date) value(:title,:nickname,:text,now())");
				$ps -> bindValue(':title' ,$title , PDO::PARAM_STR);
				$ps -> bindValue(':nickname' ,$nickname , PDO::PARAM_STR);
				$ps -> bindValue(':text' ,$text , PDO::PARAM_STR);
				$ps -> execute();
			}catch(PDOExcpetion $e){
				exit($e -> getMessage());
			}
		}

		public function getData(){
			try{
				$ps = $this -> db -> prepare("select*from openboard");
				$ps -> execute();
				$rs = $ps -> fetchAll(PDO::FETCH_ASSOC);
			}catch(PDOExcpetion $e){
				exit($e -> getMessage());
			}
			return $rs;
		}

		public function getBoardData($num){
			try{
				$ps = $this -> db -> prepare("select*from openboard where num = :num");
				$ps -> bindValue(':num' ,$num , PDO::PARAM_INT);
				$ps -> execute();
				$rs = $ps -> fetch(PDO::FETCH_ASSOC);
			}catch(PDOExcpetion $e){
				exit($e -> getMessage());
			}
			return $rs;
		}

		public function getOnePageList($start , $row){
			try{
				$ps = $this -> db -> prepare('select*from openboard order by num desc limit :start,:row');
				$ps -> bindValue(":start",$start,PDO::PARAM_INT);
				$ps -> bindValue(":row",$row,PDO::PARAM_INT);
				$ps -> execute();
				$rs = $ps -> fetchAll(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
			return $rs;
		}

		public function getListCount(){
			try{
				$ps = $this -> db -> prepare("select count(*) from openboard");
				$ps -> execute();
				$rs = $ps -> fetchColumn();
			}catch(PDOExcpetion $e){
				exit($e -> getMessage());
			}
			return $rs;
		}

		public function updateData($num,$title,$text){
			try{
				$ps = $this -> db -> prepare("update openboard set title=:title ,text=:text where num=:num");
				$ps -> bindValue(':title' ,$title , PDO::PARAM_STR);
				$ps -> bindValue(':text' ,$text , PDO::PARAM_STR);
				$ps -> bindValue(':num' ,$num , PDO::PARAM_INT);
				$ps -> execute();
			}catch(PDOExcpetion $e){
				exit($e -> getMessage());
			}
		}

		public function delete($num){
			try{
				$ps = $this -> db -> prepare("delete from openboard where num=:num");
				$ps -> bindValue(':num' ,$num , PDO::PARAM_INT);
				$ps -> execute();
			}catch(PDOExcpetion $e){
				exit($e -> getMessage());
			}
		}
	}
?>