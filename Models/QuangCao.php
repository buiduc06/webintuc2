<?php 

require_once 'BaseModel.php';
require_once 'User.php';

/**
* 
*/
class QuangCao extends BaseModel
{
	
public $tableName='quangcao';
}
function getTacGia5(){
	$NameTacGia5 = User::where(['id','17']);
		return $NameTacGia5;
}

 ?>
