<?php 
require_once 'BaseController.php';
require_once 'Models/User.php';
require_once 'Models/Tintuc.php';
require_once 'Models/LoaiTin.php';

/**
* 
*/
class DeleteController extends BaseController
{


	function XoaBaiViet(){
	$id=$_POST['id'];
	$xoatintuc=new Tintuc();
	$xoatintuc->id="$id";
	$xoatintuc->delete();
	return $this->redirect("admin/bai-viet?delete=success");
	}

	function XoaThanhVien(){
	$id=$_POST['id'];
	$xoathanhvien=new User();
	$xoatintucofthanhvien1=TinTuc::delete2(['create_by',"$id"]);
	$xoatintucofthanhvien2=Comment::delete2(['idUser',"$id"]);
	$xoatintucofthanhvien3=QuangCao::delete2(['create_by',"$id"]);
	$xoatintucofthanhvien4=slide::delete2(['create_by',"$id"]);
	$xoathanhvien->id="$id";
	$xoathanhvien->delete();
	$checkDelete=User::findOne($id);
	if (!empty($checkDelete)) {
		return $this->redirect("admin/thanh-vien?deletefail=faile");
	}else{
	return $this->redirect("admin/thanh-vien?delete=success");
}
	}

	function XoaDanhMuc(){
	$id=$_POST['id'];
	$xoatintuc=new LoaiTin();
	$XoaTinTucOfDanhMuc=TinTuc::delete2(['idLoaiTin',"$id"]);
	$xoatintuc->id="$id";
	$xoatintuc->delete();
	$checkDanhMuc=LoaiTin::findOne($id);
	if (!empty($checkDanhMuc)) {
	return $this->redirect("admin/danh-muc?deletefail=error");
	}else{
	return $this->redirect("admin/danh-muc?delete=success");
}
	}
	


}
 ?>