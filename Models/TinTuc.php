<?php 
/**
* 
*/
require_once 'BaseModel.php';
require_once 'LoaiTin.php';
require_once 'User.php';
class TinTuc extends BaseModel
{
public $tableName ='tintuc';
public $columns = [	'TieuDe', 'TieuDeKhongDau', 'TomTat', 
						'NoiDung','Hinh', 'idLoaiTin','create_by'];

function getTacGia(){
	$NameTacGia = User::findOne($this->create_by);
		return $NameTacGia;
}
function getTacGia2(){
	$NameTacGia2 = User::findOne(17);
		return $NameTacGia2;
}


function GetLoaiTin(){
	$getLoaiTin=TheLoai::findOne($this->idLoaiTin);
	return $getLoaiTin;
}


function GetLoaiTin2(){
	$getLoaiTin=LoaiTin::findOne($this->idLoaiTin);
	return $getLoaiTin;
}


}
 ?>