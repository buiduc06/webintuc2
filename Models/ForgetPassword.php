<?php require_once 'BaseModel.php'; 
/**
* 
*/
class ForgetPassword extends BaseModel
{
	
	public $tableName='forget_password';
	public $columns =['email','token','created_date'];
}


?>