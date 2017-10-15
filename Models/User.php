<?php require_once 'BaseModel.php'; 
require_once 'Slide.php';
require_once 'TinTuc.php';
/**
* 
*/
class User extends BaseModel
{
	
	public $tableName='users';
	public $columns= ['name','username','email','password','created_at','updated_at','avatar','gender','GioiThieu','active'];
}
function getsosp(){
		$getsoSp=TinTuc::sqlbullder(["SELECT COUNT(*) AS sobai FROM tintuc WHERE create_by=$this->id"]);
	return $getsoSp;
}


?>