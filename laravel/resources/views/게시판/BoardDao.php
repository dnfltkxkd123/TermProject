<?php
	class BoardDao{
		private $db;

		public function __construct(){
			try{
				$this -> db = new PDO("mysql:host=localhost;dbname=php","root","");
				$this -> db -> setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
				$this -> db -> exec("set names utf8");
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
		}

		//게시판의 전체 글수 (전체 레코드 수)반환
		public function getDataCount(){
			try{
				$ps = $this -> db -> prepare("select count(*) from board");
				$ps -> execute();
				$result = $ps -> fetchColumn();
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
			return $result;
		}

		//$num번 게시글의 데이터 반환
		public function getData($num){
			try{
				$ps = $this -> db -> prepare("select*from board where num = :num");
				$ps -> bindValue(":num",$num,PDO::PARAM_INT);
				$ps -> execute();
				$result = $ps->fetch(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
			return $result;
		}

		//$start번부터 $row개의 게시글 데이터 반환(2차원 배열)
		public function getOnePageList($start,$rows){
			try{
				$ps = $this -> db -> prepare("select*from board order by num desc limit :start,:rows");
				$ps -> bindValue(":start",$start,PDO::PARAM_INT);
				$ps -> bindValue(":rows",$rows,PDO::PARAM_INT);
				$ps -> execute();
				$result = $ps -> fetchAll(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
			return $result;
		}

		//새글을 DB에 추가
		public function insertData($writer,$title,$content){
			try{
				$ps = $this -> db -> prepare("insert into board(writer,title,content,regtime,hits) value(:writer,:title,:content,:regtime,0)");
				$regtime = date("Y-m-d H:i:s");
				$ps -> bindValue(":writer",$writer,PDO::PARAM_STR);
				$ps -> bindValue(":title",$title,PDO::PARAM_STR);
				$ps -> bindValue(":content",$content,PDO::PARAM_STR);
				$ps -> bindValue(":regtime",$regtime,PDO::PARAM_INT);
				$ps -> execute();
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
		}

		//$num번 개시글 업데이트
		public function updateData($num,$writer,$title,$content){
			try{
				$ps = $this -> db -> prepare("update board set writer=:writer, title=:title, content=:content, regtime=:regtime where num=:num");
				$regtime = date("Y-m-d H:i:s");
				$ps -> bindValue(":writer",$writer,PDO::PARAM_STR);
				$ps -> bindValue(":title",$title,PDO::PARAM_STR);
				$ps -> bindValue(":content",$content,PDO::PARAM_STR);
				$ps -> bindValue(":regtime",$regtime,PDO::PARAM_INT);
				$ps -> bindValue(":num",$num,PDO::PARAM_INT);
				$ps -> execute();
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
		}

		//$num번 게시글 삭제
		public function deleteData($num){
			try{
				$ps = $this -> db -> prepare("delete from board where num=:num");
				$ps -> bindValue(":num",$num,PDO::PARAM_INT);
				$ps -> execute();

			}catch(PDOException $e){
				exit($e -> getMessage());
			}
		}
		//$num 게시글 조회수 증가
		public function increaseHits($num){
			try{
				$ps = $this -> db -> prepare("update board set hits = hits+1 where num=:num");
				$ps -> bindValue(":num",$num,PDO::PARAM_INT);
				$ps -> execute();
			}catch(PDOExeption $e){
				exit($e -> getMessage());
			}
		}
	}
?>