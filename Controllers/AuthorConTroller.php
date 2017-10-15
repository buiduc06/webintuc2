<?php 
/**
* 
*/
require_once 'BaseController.php';
require_once 'Models/User.php';
class AuthorController extends BaseController
{
	// function bảo vệ dữ liệu
	function __construct()
	{
	if (isset($_GET['id'])!=null) {//check sự tồn tại của id
		$id=$_GET['id']; // gán vào $id nếu trả về true
		if (is_numeric($id)) {//check xem id có phải là số không. chống người dùng phá

		}else{
			return $this->redirect("not-fonud");
			die;
			//điều hướng đến not-fonud nếu trả về false
			}
	}else{
		return $this->redirect("not-fonud");
		die;
		//điều hướng đến not-fonud nếu trả về false
			}
	}

	

	function index(){
$id=$_GET['id'];
$author=User::where(['id',"$id"]);

		return $this->render("views/Author.php", ['author' => $author], 'views/main.layout.php');

	}

}


 ?>