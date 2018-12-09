<?php
	class MemberDao{
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

		public function insertMember($id,$name,$nickname,$email,$pw){
			try{
				$ps = $this -> db -> prepare('insert into member(id,name,nickname,email,pw) value(:id,:name,:nickname,:email,:pw)');
				$ps -> bindValue(':id',$id,PDO::PARAM_STR);
				$ps -> bindValue(':name',$name,PDO::PARAM_STR);
				$ps -> bindValue(':nickname',$nickname,PDO::PARAM_STR);
				$ps -> bindValue(':email',$email,PDO::PARAM_STR);
				$ps -> bindValue(':pw',$pw,PDO::PARAM_STR);
				$ps -> execute();
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
		}

		public function insertMember2($id,$name,$nickname,$email,$pw,$img){
			try{
				$ps = $this -> db -> prepare('insert into member(id,name,nickname,email,pw,img) value(:id,:name,:nickname,:email,:pw,:img)');
				$ps -> bindValue(':id',$id,PDO::PARAM_STR);
				$ps -> bindValue(':name',$name,PDO::PARAM_STR);
				$ps -> bindValue(':nickname',$nickname,PDO::PARAM_STR);
				$ps -> bindValue(':email',$email,PDO::PARAM_STR);
				$ps -> bindValue(':pw',$pw,PDO::PARAM_STR);
				$ps -> bindValue(':img',$img,PDO::PARAM_STR);
				$ps -> execute();
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
		}

		public function getMember($id){
			try{
				$ps = $this -> db -> prepare('select*from member where id=:id');
				$ps -> bindValue(':id',$id,PDO::PARAM_STR);
				$ps -> execute();
				$rs = $ps -> fetch(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
				return $rs;
		}

		public function getNickname($nickname){
			try{
				$ps = $this -> db -> prepare('select*from member where nickname=:nickname');
				$ps -> bindValue(':nickname',$nickname,PDO::PARAM_STR);
				$ps -> execute();
				$rs = $ps -> fetch(PDO::FETCH_ASSOC);
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
				return $rs;
		}

		public function updateMember($id,$name,$nickname,$email,$pw,$img){
			try{
				$ps = $this -> db -> prepare('update member set name=:name , nickname=:nickname , email=:email , pw=:pw , img=:img where id=:id;');
				$ps -> bindValue(':id',$id,PDO::PARAM_STR);
				$ps -> bindValue(':name',$name,PDO::PARAM_STR);
				$ps -> bindValue(':nickname',$nickname,PDO::PARAM_STR);
				$ps -> bindValue(':email',$email,PDO::PARAM_STR);
				$ps -> bindValue(':pw',$pw,PDO::PARAM_STR);
				$ps -> bindValue(':img',$img,PDO::PARAM_STR);
				$ps -> execute();
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
		}

		public function updateMemberNoneImg($id,$name,$nickname,$email,$pw){
			try{
				$ps = $this -> db -> prepare('update member set name=:name , nickname=:nickname , email=:email , pw=:pw  where id=:id;');
				$ps -> bindValue(':id',$id,PDO::PARAM_STR);
				$ps -> bindValue(':name',$name,PDO::PARAM_STR);
				$ps -> bindValue(':nickname',$nickname,PDO::PARAM_STR);
				$ps -> bindValue(':email',$email,PDO::PARAM_STR);
				$ps -> bindValue(':pw',$pw,PDO::PARAM_STR);
				$ps -> execute();
			}catch(PDOException $e){
				exit($e -> getMessage());
			}
		}
	}
?>