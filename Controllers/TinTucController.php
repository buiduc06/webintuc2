<?php 

require_once 'BaseController.php';
require_once 'models/TinTuc.php';
require_once 'models/Comment.php';

/**
* 
*/
class TinTucController extends BaseController
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



	function GetPage(){
	$id=$_GET['id'];
	$page=TinTuc::where(['id',"$id"]);
	$pag09=LoaiTin::sqlbullder(["SELECT * FROM loaitin INNER JOIN theloai ON loaitin.idTheLoai=theloai.id
	INNER JOIN tintuc ON loaitin.id=tintuc.idLoaiTin
	WHERE tintuc.id=$id"]);
		return $this->render("views/TinTuc.php", ['page' => $page,'pag09' => $pag09], 'views/main.layout.php');

	}

	function AddComment(){
		$id=$_GET['id'];
		$model = new Comment();
		$model->idTinTuc =$id;
		$model->NoiDung =htmlspecialchars($_POST['comment']);
		date_default_timezone_set('Asia/Ho_Chi_Minh');// thiết lập múi giờ mặc định cho website
		$model->created_at = date('Y-m-d H:i:s');
		$model->insert();
		return $this->redirect("Tin-Tuc?id=$id");

	}
}


 ?>