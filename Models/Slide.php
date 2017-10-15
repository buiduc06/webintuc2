<?php require_once 'BaseModel.php'; 
require_once 'TheLoai.php';
require_once 'User.php';
/**
* 
*/
class Slide extends BaseModel
{
	
	public $tableName='slide';
// function lấy ra tên thể loại ở slide showw
	function getNameslide(){
			$Nameslide = LoaiTin::findOne($this->idLoaiTin);
		return $Nameslide;
	}

	// function lay ra nguoi tao tin do

	function getNamecreate(){
			$Namecreate = User::findOne($this->create_by);
		return $Namecreate;
	}
}



?>