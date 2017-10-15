<?php 
/**
* 
*/
require_once 'BaseModel.php';
require_once 'LoaiTin.php';
class TheLoai extends BaseModel
{
	public $tableName ='theloai';

	function getLoaiTinCon(){
		$getLoaiTinCon=LoaiTin::findOne($this->id);
	return $getLoaiTinCon;
	}

}



 ?>