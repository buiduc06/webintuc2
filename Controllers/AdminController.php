<?php

require_once 'BaseController.php';
include_once('Models/TheLoai.php');
include_once('Models/LoaiTin.php');
include_once('Models/TinTuc.php');
include_once('Models/Slide.php');
include_once('Models/User.php');
include_once('Models/comment.php');
include_once('Models/Video.php');
include_once('Models/QuangCao.php');

/**
* 
*/
/**
* 
*/

class AdminController extends BaseController
{
	
	
	function index(){
		$baiviet =TinTuc::CountRow('*');
		$soTheLoai=TheLoai::CountRow('*');
		$soLoaiTin=LoaiTin::CountRow('*');
		$soUser=User::CountRow('*');
		$soComment=Comment::CountRow('*');
		$soLuotXem=TinTuc::sqlbullder(["SELECT SUM(SoLuotXem) AS soluotxem FROM tintuc"]);

		$AllInfo=array();
		$AllInfo=[
			'baiviet' => $baiviet,
			'soTheLoai' => $soTheLoai,
			'soLoaiTin' => $soLoaiTin,
			'soUser' => $soUser,
			'soComment' => $soComment,
			'soLuotXem' => $soLuotXem
		];
		return $this->render("views/admin/admin.homepage.php", $AllInfo, 'views/admin/admin.layout.php');

	}


	function BaiViet(){
		$Showbaiviet=Tintuc::all();
		if (isset($_GET['delete'])=='success') {
			$msg="xóa bài viết thành công";
		}elseif (isset($_GET['update'])=='success') {
			$msg="cập nhật bài viết thành công";
		}elseif (isset($_GET['uploadimage'])=='error') {
			$msg="upload ảnh lỗi. vui lòng kiểm tra lại";
		}elseif (isset($_GET['insert'])=='success') {
			$msg="Tạo Bài Viết Thành Công";
		}
		else{
			$msg=null;
		}


		return $this->render("views/admin/BaiViet/index.php",['Showbaiviet' => $Showbaiviet,'msg' => $msg], 'views/admin/admin.layout.php');
	}
	function ThemBaiViet(){
		$showTinTuc11=LoaiTin::all();
		if (isset($_GET['uploadimage'])=='error') {
		$msg="upload ảnh lỗi. vui lòng kiểm tra lại";
	}
		return $this->render("views/admin/BaiViet/ThemBaiViet.php",['showTinTuc11' => $showTinTuc11,'msg' => $msg], 'views/admin/admin.layout.php');
	}

	function SuaBaiViet(){
		if (isset($_POST['id'])) {
			$id=$_POST['id'];
		}
		if (isset($_GET['id'])) {
			$id=$_GET['id'];
		}
		if (isset($_GET['uploadimage'])) {
			$msg='định dạng ảnh không hợp lệ';
		}
		$showTinTuc11=TinTuc::findOne("$id");
		return $this->render("views/admin/BaiViet/FormUpdate.php",['showTinTuc11' => $showTinTuc11 , 'msg' => $msg], 'views/admin/admin.layout.php');
	}

	function BaiViet_Submit(){

		$id = isset($_POST['id'])==true ? $_POST['id'] : null;
		$TieuDe = isset($_POST['txtieude'])==true ? $_POST['txtieude'] : null;
		$TieuDeKhongDau = isset($_POST['txtieudekhongdau'])==true ? $_POST['txtieudekhongdau'] : null;
		$tomtat = isset($_POST['txtomtat'])==true ? $_POST['txtomtat'] : null;
		$NoiDung = isset($_POST['txnoidung'])==true ? $_POST['txnoidung'] : null;
		$DanhMuc = isset($_POST['txdanhmuc'])==true ? $_POST['txdanhmuc'] : null;
		$Tacgia = isset($_POST['txtacgia'])==true ? $_POST['txtacgia'] : null;

		if ($id != null) {
			// phần dành cho update
			$model=Tintuc::findOne($id);
			$upLoadHA=new BaseModel();
			$upLoadHA->filename='txhinhanh';
			$upLoadHA->UploadAnh1();
			$HAA=$upLoadHA->imgupload;
		// neu nguoi dung khong chon anh thi mac dinh se lay anh co san trong db
		if (!empty($upLoadHA->error)) {
				return $this->redirect("admin/bai-viet/sua?uploadimage=error&id=$id");
				die;
			}else{
			$HA = (!empty($HAA)) ? $HAA : $model->Hinh ;
		}
		}else{
			$model = new Tintuc();

// phần validate dành cho insert
			$upLoadHA=new BaseModel();
			$upLoadHA->filename='txhinhanh';
			$upLoadHA->UploadAnh();
			if (!empty($upLoadHA->error)) {
				return $this->redirect('admin/bai-viet/them-bai-viet?uploadimage=error');
				die;
			}else{
				$HA=$upLoadHA->imgupload;
			}
			

		}


		$model->TieuDe = $TieuDe;
		$model->TieuDeKhongDau = $TieuDeKhongDau;
		$model->TomTat = $tomtat;
		$model->NoiDung = $NoiDung;
		$model->idLoaiTin = $DanhMuc;
		$model->create_by = $Tacgia;
		$model->created_at=date('Y-m-d H:i:s');
		$model->Hinh = $HA;

		if(isset($model->id)){
			$model->update();

			return $this->redirect("admin/bai-viet?update=success");

		}else{
			$model->insert();
			return $this->redirect("admin/bai-viet?insert=success");

		}



	}



	function DanhMuc(){
		$showdanhmuc=LoaiTin::all();
		$Showbaiviet=Tintuc::all();
		if (isset($_GET['delete'])=='success') {
			$msg="xóa Danh Mục thành công";
		}elseif (isset($_GET['update'])=='success') {
			$msg="Update Danh Mục thành công";
		}elseif (isset($_GET['deletefail'])=='error') {
			$msg="<p style='color:red;'>Xóa Danh Mục Thất Bại Vui Lòng kiểm tra lại liên kết giữa các bảng</p>";
		}
		else{
			$msg=null;
		}

		return $this->render("views/admin/DanhMuc/index.php", ['showdanhmuc' => $showdanhmuc , 'msg' =>$msg], 'views/admin/admin.layout.php');
	}


	function ThemDanhMuc(){
		$laytheloai= TheLoai::all();
		if (isset($_GET['createf'])) {
			$msg="<p style='color:red;font-size:14px'>Tên Danh Mục Đã Tồn Tại Trên Hệ Thống</p>";
		}if (isset($_GET['creat'])) {
			$msg="<p style='color:red;font-size:14px'>Tên Danh Mục Không Được Trùng Với Tên Thể Loại</p>";
		}
		return $this->render("views/admin/DanhMuc/themdanhmuc.php", ['laytheloai' => $laytheloai ,'msg' => $msg], 'views/admin/admin.layout.php');
	}
	function SubmitDanhMuc(){
		if (isset($_POST['danhmuc'])) {
			$danhmuc=$_POST['danhmuc'];
			$checkdanhmuc=Loaitin::where(['Ten',"$danhmuc"]);
			$checkdanhmuc2=TheLoai::where(['Ten',"$danhmuc"]);
			if (!empty($checkdanhmuc)) {
				return $this->redirect("admin/danh-muc/create?createf=faile");
			}else if (!empty($checkdanhmuc2)) {
				return $this->redirect("admin/danh-muc/create?creat=faile");
			}
			else{
				$inser=new Loaitin();
				$inser->Ten=$danhmuc;
				$inser->idTheLoai=$_POST['TheLoai'];
				$inser->insert();
				return $this->redirect("admin/danh-muc?insert=success");
				
			}
		}

	}



	function ThanhVien(){
		$ShowThanhVien=User::all();

		if (isset($_GET['delete'])=='success') {
			$msg="xóa Thành Viên thành công";
		}elseif (isset($_GET['update'])=='success') {
			$msg="Update Thành Viên thành công";
		}elseif (isset($_GET['deletefail'])=='faile') {
			$msg="<p style='color:red;'>Xóa Thành Viên Thất Bại Vui Lòng kiểm tra lại liên kết giữa các bảng</p>";
		}
		else{
			$msg=null;
		}

		return $this->render("views/admin/User/index.php", ['ShowThanhVien' => $ShowThanhVien , 'msg' =>$msg ], 'views/admin/admin.layout.php');
	}

	function BlockUser(){
		$ShowThanhVien=User::all();
		if (isset($_GET['block'])) {
			$name=$_GET['block'];
			$msg ="block user $name Thành Công";
		}elseif (isset($_GET['unblock'])) {
			$name=$_GET['unblock'];
			$msg ="Mở Khóa user $name Thành Công";
		}
		else{
			$msg=null;
		}
		return $this->render("views/admin/User/blockuser.php", ['ShowThanhVien' => $ShowThanhVien , 'msg' =>$msg ], 'views/admin/admin.layout.php');
	}
	function BlockUserTrue(){
		if (isset($_POST['id'])) {
			$id=$_POST['id'];
			$blockus=User::findOne($id);
			$blockus->active='2';
			$blockus->update();
			$name="$blockus->name";
			return $this->redirect("admin/thanh-vien/block-user?block=$name
				");
		}else{}
		
	}
	function UnBlockUserTrue(){
		if (isset($_POST['id'])) {
			$id=$_POST['id'];
			$blockus=User::findOne($id);
			$blockus->active='1';
			$blockus->update();
			$name="$blockus->name";
			return $this->redirect("admin/thanh-vien/block-user?unblock=$name
				");
		}else{}
	}




}


?>