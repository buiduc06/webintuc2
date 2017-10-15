<?php 

/**
* 
*/
require_once 'BaseController.php';
require_once 'Models/LoaiTin.php';
require_once 'Models/Comment.php';
require_once 'Models/TheLoai.php';
require_once 'Models/TinTuc.php';
require_once 'Models/User.php';
require_once 'Models/ForgetPassword.php';
include_once('Models/QuangCao.php');
class HomeController extends BaseController
{
	
// function đổ dữ liệu ra trang chủ

	function index(){

// lay ra info phan the gioi
		$getbody1=TinTuc::whereLimit(['id','<','5','1','2']);
		$getbody2=TinTuc::whereLimit(['id','<','5','2','4']); 
		$getbody3=TinTuc::whereLimit(['id','<','7','4','6']);  
// hết phần lấy ra TheGioi


// phần hình sự - phap luat
		$PhapLuat1=TinTuc::whereLimit(['idLoaiTin','6','0','3']);

// <!-- phần văn hóa -->
		$VanHoa=LoaiTin::where(['idTheLoai','4']);
		$VanHoa0=TinTuc::whereLimit(['idLoaiTin','4','0','10']);

// TheThao
		$TheThao=TinTuc::whereLimit(['idLoaiTin','6','1','8']);

 // <!-- Đời Sống --> //NHẦM TÊN
		$TheGioi=TheLoai::where(['id','7',]);
		$TheGioi1=TinTuc::whereLimit(['idLoaiTin','7','1','4']);

// commented
		$commented=Comment::WhereLimit(['id','>','0','1','4']);

// TIN HOT
		$HotNews=TinTuc::WhereLimit(['id','>','0','1','6']);

// phần lấy ra bài viết mới nhất
		$baiVietMoi =TinTuc::sqlbullder(["SELECT * FROM tintuc ORDER BY id DESC LIMIT 0,6"]);


  // PHẦN DÀNH CHO QUẢNG CÁO
		$QuangCao=QuangCao::whereLimit(['id','>','0','0','3']);

		$allinfo=array();

// phần echo ra thong bao
		if (isset($_GET['sendmail'])=='successs') {
			$msg="gửi Mail Thành Công Vui Vòng Check Email Để lấy Lại password";
		}else if (isset($_GET['loginerror'])=='chua-activie') {
			$msg="Tài Khoản Chưa Được Kích Hoạt Vui Lòng Xác thực mail hoặc liên hệ quản trị viên";
		}else if (isset($_GET['reset-password'])=='sucesss') {
			$msg='reset mật khẩu thành công vui lòng check mail để lấy lại mật khẩu';
		}else if (isset($_GET['tk'])=='kotontaitoken') {
			$msg="token hết hạn hoặc die vui lòng lấy lại token mới";
		}
		else{
			$msg=null;
		}
		
// gan cac gia tri vao mang
		$allinfo=['getbody1' => $getbody1,
		'getbody2' => $getbody2,
		'getbody3' => $getbody3,
		'PhapLuat1' => $PhapLuat1,
		'VanHoa' => $VanHoa,
		'VanHoa0' => $VanHoa0,
		'TheThao' => $TheThao,
		'TheGioi' => $TheGioi,
		'TheGioi1' => $TheGioi1,
		'commented' => $commented,
		'HotNews' => $HotNews,
		'baiVietMoi' => $baiVietMoi,
		'QuangCao' => $QuangCao,
		'msg' => $msg
	];


	return $this->render("views/homepage.php", $allinfo, 'views/main.layout.php');

}

function LoginBasic(){

	return $this->render("views/account/login.php", [''], 'views/account/account.layout.php');
}

function Login(){

// password được mã hóa theo chuẩn sha1
	if (isset($_POST['login_email']) && $_POST['login_pass']) {
		$loginemail=addslashes($_POST['login_email']);// suwr dungj haam addslashes de bao ve data
		$loginpass=sha1(addslashes($_POST['login_pass']));// mã hóa theo sha1
		$checkmail=User::where(['email',"$loginemail"]);// tim xem co email nao gioing vs mail ng dung nhap trong cldl ko 
		if (!empty($checkmail)) {// neu co email thi tien hanh xuat ra theo email va check pass word
			foreach ($checkmail as $key1 ) {
				if ($loginemail==$key1->email && $loginpass==$key1->password ) {
		             	if ($key1->level==1 && $key1->email='admin@gmail.com' && $key1->password='$2y$10$CEdbdsSMU9Nv.6yjdRMEtOhR0kdIiOBWtNR2Bup9upjueOPbcsM9m' ) {// neu level bang 1 thi la admin
		             		$_SESSION['name'] = $key1->username;//gan session bang usename
		             		$_SESSION['level'] ='admin';
		             		$_SESSION['email'] =$loginemail;
		             		return $this->redirect('admin');
		             		exit();
		             	}
		             	else if($key1->level==2 && $key1->active==1){
		             		$_SESSION['name'] = $key1->username;//gan session bang usename
		             		$_SESSION['level'] ='member';
		             		$_SESSION['email'] =$key1->email;
		             		return $this->redirect('member');
		             		exit();
		             	}else{
		             		return $this->redirect('index?loginerror=chua-activie');
		             	}
		             }else{
		             	return $this->redirect('login-account-basic?notification=loginfasles');
		             }             
		         }
		     }else{
		     	return $this->redirect('login-account-basic?notification=loginfasles');
		     }
		 }else{
		 	return $this->redirect('login-account-basic?notification=loginfasles');
		 }

		 function LogoutDetroy(){
		 	session_destroy();
		 }


	// 
	//PHẦN LẤY LẠI PASSS submit
		}
		function ResetPasswordFrom()
		{
			session_destroy();
			return $this->render("views/account/form_resetpass.php", [''], 'views/account/account.layout.php');
		}
		function ResetPassword(){
			// session_destroy();
			if (isset($_POST['forgot_email'])) {
				$email=$_POST['forgot_email'];
				$checkMail=User::where(['email',"$email"]);
				
				$laydate=date('Y-m-d');
				if (!empty($checkMail)) {
					$InsetToken=new ForgetPassword();
					$InsetToken->email=$email;
					$InsetToken->token=md5($laydate).sha1($email);// mã hóa token
					$InsetToken->insert();
					return $this->redirect("sendmail.php?token=$InsetToken->token&mail=$email");
				}else{
					return $this->redirect('index?reset-password=sucesss');
				}
			}else{
				return $this->redirect('index?reset-password=sucesss');
			}
		}

		function ResetpwSubmit()// function reset password

		{
			// session_destroy();
			if (isset($_GET['token'])) { //check isset token
				if (!empty($_GET['token'])) {
					$token=$_GET['token'];
					$layInfoacc=ForgetPassword::where(['token',"$token"]); //check isset token in db
					if (!empty($layInfoacc)) {
						foreach ($layInfoacc as $layInfoacc1 ) { // open foreach put out dated
							$datecu=$layInfoacc1->created_date;
						}
						$datemoi=date('Y-m-d H:i:s'); // put out date 
						$showdate=ForgetPassword::sqlbullder(["SELECT DATEDIFF('$datemoi','$datecu') AS demsongay"]); // take date - dated As demsongay
						foreach ($showdate as $showdate ) { // open foreach put out demsongay as showbdate
							$shownbdate=$showdate->demsongay;
						}
						if ($shownbdate<1) { // if $showndate smailler than 1 show token can use and for users change password
							$UserInfo=User::where(['email',"$layInfoacc1->email"]);
							return $this->render("views/account/resetpassword.php", ['UserInfo' =>$UserInfo], 'views/account/account.layout.php');


						}else{ // else show notification token die
							echo "Link reset mật khẩu đã hết hạn xin mời Lấy Lại Link ";
							echo "<a href='index' > về trang chủ</a>";
						}
					}
					else{
						return $this->redirect('index?tk=kotontaitoken');
					}
				}
				else{
					return $this->redirect('index');
				}
			}else{
				return $this->redirect('index');
			}
		}

//HẾT PHẦN LẤY LẠI PASS VÀ ĐỔI

		function RegisterAccount(){

			return $this->render("views/account/Register.php", [''], 'views/account/account.layout.php');
		}

		function SubmitRegisterAccount(){
			if (isset($_POST['email'])!=null) {
				$email=$_POST['email'];
				$checkmail=User::where(['email',"$email"]);
				if (empty($checkmail)) {
					$name=$_POST['name'];
					$password=$_POST['password'];
					$usein=new User();
					$usein->name=$_POST['name'];
					$usein->username=$_POST['name'];
					$usein->password=sha1($_POST['pwd']);
					$usein->email=$email;
					$usein->level='2';
					$usein->active='0';
					$usein->insert();
					return $this->redirect('login-account-basic?create=success');
				}else{
					return $this->redirect('register-account?notification=emaildatontai');
				}

			}else{
				return $this->redirect('register-account?notification=emaildatontai');
			}
		}

		// đổi mật khẩu
		function ChangePassword(){
			$email=$_SESSION['email'];
			$UserInfo=User::where(['email',"$email"]);
			return $this->render("views/account/changepassword.php", ['UserInfo' =>$UserInfo], 'views/account/account.layout.php');
			
		}




// phần update pass và db
		function SubmitChangePassword(){
			if (isset($_POST['iddd'])) {
				$token=$_POST['token'];
				$id=$_POST['iddd'];
				$usscheck=User::findOne($id);
				if ($usscheck->password != sha1($_POST['password'])) {

					//if == true .. update password in db and delete token
					$chagepass=User::findOne("$id");
					$chagepass->password=sha1($_POST['password']);
					$chagepass->update();
					$deleteToken=ForgetPassword::delete2(['token',"$token"]); // delete token
					return $this->redirect("login-account-basic?update='updatesuccess'");

				}else{
					return $this->redirect("resetpw-submit?token=$token&errorpass=1");die;
				}
			}else{
				echo "ko tìm thấy id người dùng";
			}
		}





	}

	?>