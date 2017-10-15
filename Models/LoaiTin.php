<?php 
/**
* 
*/
require_once 'BaseModel.php';
require_once 'TinTuc.php';
require_once 'TheLoai.php';

class LoaiTin extends BaseModel 
{
	public $tableName ='loaitin';
	public $columns =['idTheLoai', 'Ten', 'TenKhongDau', 'created_at', 'updated_at'];

function getTheLoai(){
	$getTheLoai2 = TheLoai::findOne($this->idTheLoai);
		return $getTheLoai2;

	}
	function getSoBaiViet(){
		$getSobaiviet=TinTuc::sqlbullder(["SELECT COUNT(*) AS sobai FROM tintuc WHERE idLoaiTin=1"]);
		return $getSobaiviet;
	}
}


 ?>