<?php 
/**
* 
*/
class BaseModel
{


	public $tableName ='loaitin';



	function insert(){

		$sql = "insert into $this->tableName ";
		$sql .= "(";
		foreach ($this->columns as $col) {
			if(isset($this->{$col})){
				$sql .= " $col, ";
			}
			
		}
		$sql = rtrim($sql, ", ");
		$sql .= ")";
		$sql .= " values ";
		$sql .= "(";
		foreach ($this->columns as $col) {
			if(isset($this->{$col})){
				$sql .= "'".$this->{$col}. "', ";
			}
		}
		$sql = rtrim($sql, ", ");
		$sql .= ")";
		// var_dump($sql);die;
		$conn = $this->getConnect();
		
		$conn->beginTransaction(); 
		
		try{

			$stmt = $conn->prepare($sql);
			$stmt->execute();

			$this->id = $conn->lastInsertId(); 
			$conn->commit(); 
			if($this->id > 0){
				return $this;
			}

			return false;
		}
		catch(PDOException $ex){
			$conn->rollback(); 
			return false;
		}
	}


// function update dữ liệu
	function update(){

		$sql = "update $this->tableName ";
		$sql .= " set ";
		foreach ($this->columns as $col) {
			$sql .= " $col = '" . $this->{$col} ."', ";
		}
		$sql = rtrim($sql, ", ");
		
		$sql .= " where id = '" . $this->id ."' ";
		$conn = $this->getConnect();
		$conn->beginTransaction(); 
		// // echo "<pre>";
		// // var_dump($sql);
		// die;
		try{

			$stmt = $conn->prepare($sql);
			$stmt->execute();

			$conn->commit(); 
			return $this;
		}
		catch(PDOException $ex){
			$conn->rollback(); 
			return false;
		}

	}


	static function CountRow($row){
		$model = new static();

		// xay dung ra cau select voi table name tu lop static
		$model->queryBuilder = "select count('$row') as sobai from " . $model->tableName;	
		
		return $model->get();// mở kết nối đến cơ sở dữ liệu
	}

	

	static function where($arr = []){
		// tao ra lop static 
		$model = new static();

		// xay dung ra cau select voi table name tu lop static
		$model->queryBuilder = "select * from " . $model->tableName;

		$model->queryBuilder .= " where ";
		if(count($arr) == 2){
		//$arr[0] là tên bảng $arr[1] là giá trị 
			$model->queryBuilder .= $arr[0] . " = '$arr[1]'"; 

		}
		if(count($arr) == 3){
			//$arr[0] là tên bảng $arr[1] là toán tử(= > <..) $arr[2] giá trị. EX: WHERE id > 1
			$model->queryBuilder .= $arr[0] . " " . $arr[1] . " '$arr[2]'"; 			
		}
		
		return $model->get();// mở kết nối đến cơ sở dữ liệu
	}

	function andWhere($arr = []){
		$this->queryBuilder .= " and ";
		if(count($arr) == 2){
			$this->queryBuilder .= $arr[0] . " = '$arr[1]'"; 
			
		}
		if(count($arr) == 3){
			$this->queryBuilder .= $arr[0] . " " . $arr[1] . " '$arr[2]'"; 
		}
		
		return $this;
	}
// lay ra limit
	static function whereLimit($arr = []){
		// tao ra lop static 
		$model = new static();

		// xay dung ra cau select voi table name tu lop static
		$model->queryBuilder = "select * from " . $model->tableName;
		$model->queryBuilder .= " where ";
		if(count($arr) == 4){
		//$arr[0] là tên bảng $arr[1] là giá trị 
			$model->queryBuilder .= $arr[0] . " = '$arr[1]' ";

			$model->queryBuilder .= " LIMIT ";
		//$arr[0] là tên bảng $arr[1] là giá trị 
			$model->queryBuilder .= $arr[2] . ',' .$arr[3]; 

		}

		if(count($arr) == 5){

//$arr[0] là tên bảng $arr[1] là giá trị 
			$model->queryBuilder .= $arr[0] . " " . $arr[1] . " '$arr[2]'"; 

			$model->queryBuilder .= " LIMIT ";
		//$arr[0] là tên bảng $arr[1] là giá trị 
			$model->queryBuilder .= $arr[3] . ',' .$arr[4]; 


		}


		return $model->get();// mở kết nối đến cơ sở dữ liệu

	}

// function where and where limit
	static function whereAndwhereLimit($arr = []){
		// tao ra lop static 
		$model = new static();

		if(count($arr) == 6){
		// xay dung ra cau select voi table name tu lop static
			$model->queryBuilder = "select * from " . $model->tableName;
			$model->queryBuilder .= " where ";
		//$arr[0] là tên bảng $arr[1] là giá trị 
			$model->queryBuilder .= $arr[0] . " = '$arr[1]' ";
			$model->queryBuilder .= " and ";
			$model->queryBuilder .= $arr[2] . " = '$arr[3]'";
			$model->queryBuilder .= " LIMIT ";
		//$arr[0] là tên bảng $arr[1] là giá trị 
			$model->queryBuilder .= $arr[4] . ',' .$arr[5]; 

		}
		if(count($arr) == 7){
// xay dung ra cau select voi table name tu lop static
			$model->queryBuilder = "select * from " . $model->tableName;
			$model->queryBuilder .= " where ";

		//$arr[0] là tên bảng $arr[1] là giá trị 
			$model->queryBuilder .= $arr[0] . " " . $arr[1] . " '$arr[2]'"; 	
			$model->queryBuilder .= " and ";
			$model->queryBuilder .= $arr[3] . " = '$arr[4]'";
			$model->queryBuilder .= " LIMIT ";
		//$arr[0] là tên bảng $arr[1] là giá trị 
			$model->queryBuilder .= $arr[5] . ',' .$arr[6]; 



		}
		return $model->get();// mở kết nối đến cơ sở dữ liệu


	}
	// truyen truc tiep cau lenh sql vao
	static function sqlbullder($arr = []){
		// tao ra lop static 
		$model = new static();

		// xay dung ra cau select voi table name tu lop static
		$model->queryBuilder = "$arr[0]";
		return $model->get();
	}

	static function all(){
		// tao ra lop static 
		$model = new static();

		// xay dung ra cau select voi table name tu lop static
		$model->queryBuilder = "select * from " . $model->tableName;
		return $model->get();
	}

	static function findOne($id){
		// tao ra lop static 
		$model = new static();

		// xay dung ra cau select voi table name tu lop static
		$model->queryBuilder = "select * from " . $model->tableName
		. " where id = '$id'";
		$result = $model->get();
		if(count($result) == 0){
			return null;
		}

		return $result[0];
	}

	function first(){

	}

	static function orderBy($arr = []){
		$model = new static();
		// $arr[0] tên cột cần sắp xếp . $arr[1] kiểu giá trị tăng hoặc giảm dần.
		if(count($arr) == 2)
		{
			$model->queryBuilder = "select * from " . $model->tableName;
			$model->queryBuilder .= " ORDER BY ";
			$model->queryBuilder .= $arr[0] . " $arr[1]"; 

		}
		if(count($arr) == 4){
			$model->queryBuilder = "select * from " . $model->tableName;
			$model->queryBuilder .= " where ";
		//$arr[0] là tên bảng $arr[1] là giá trị 
			$model->queryBuilder .= $arr[0] . " = '$arr[1]' ";
			$model->queryBuilder .= " ORDER BY ";
			$model->queryBuilder .= $arr[2] . " $arr[3]"; 
		}
		if(count($arr) == 5){
			$model->queryBuilder = "select * from " . $model->tableName;
			$model->queryBuilder .= " where ";
		//$arr[0] là tên bảng $arr[1] là giá trị 
			$model->queryBuilder .= $arr[0] . " " . $arr[1] . " '$arr[2]'"; 
			$model->queryBuilder .= " ORDER BY ";
			$model->queryBuilder .= $arr[3] . " $arr[4]"; 
		}
return $model->get();// mở kết nối đến cơ sở dữ liệu 	
}

function delete(){
	try{
		$this->queryBuilder = "delete from $this->tableName where id = '$this->id'";
		$conn = $this->getConnect();
		$stmt = $conn->prepare($this->queryBuilder);
		$stmt->execute();
		return true;
	}catch(Exception $ex){
		var_dump($ex->getMessage());
		return false;
	}
}

function get(){
	$conn = $this->getConnect();
	$stmt = $conn->prepare($this->queryBuilder);
	$stmt->execute();
	$result = $stmt->fetchAll(PDO::FETCH_CLASS, get_class($this));
	return $result;
}

static function delete2($arr= []){
	$model = new static();
	try{
		// xay dung ra cau select voi table name tu lop static
		if(count($arr) == 1){
			$model->queryBuilder = "delete from ".$model->tableName ." where id = ".$arr[0];

		}
		if(count($arr) == 2){
			$model->queryBuilder = "delete from ".$model->tableName ." where ".$arr[0]." = ". '"'.$arr[1].'"';

		}
		$model->get();
		return true;

	}catch(Exception $ex){
		var_dump($ex->getMessage());
		return false;
	}
}

function getConnect()
{
	$servername = '127.0.0.1';
	$dbname = 'php_mvc';
	$dbusername = 'root';
	$dbpwd = '';
	$conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $dbusername, $dbpwd);
	return $conn;
}




	// function validate Anh

function UploadAnh(){
	// duong dan den file anh
	$linkMucUpload=getUrl('public/image/');

	if ($_FILES[$this->filename]['name']!=NULL) {

        //phần config upload hình ảnh
		if (isset($_FILES[$this->filename]))
		{
            // Nếu file upload không bị lỗi,
            // Tức là thuộc tính error > 0
			if ($_FILES[$this->filename]["type"] != 'image/jpeg' && $_FILES[$this->filename]['type'] != 'image/png') {
				return $this->error= "bạn chỉ được upload file dưới dạng PNG và JPEG";
			}elseif ($_FILES[$this->filename]['size']>2*1024*1024) {
				return $this->error="bạn chỉ được tải lên file >2 MB";
			}
			else{
                // Upload file
				move_uploaded_file($_FILES[$this->filename]['tmp_name'], "$linkMucUpload".$_FILES[$this->filename]['name']);
				$imaup['anh']=$_FILES[$this->filename]['name'];
                // echo 'File Uploaded Thành Công';
			}
		}else{
			return $this->imgupload='320x150.jpg';
		}

	}else{
		return $this->imgupload='320x150.jpg';
	}  

       return $this->imgupload=$imaup['anh'];//trả về giá trị imgname nếu mấy kq thì gọi từ biến hứng đên imgname

       //lấy thông báo lỗi bằng cách trỏ đến error

   }

// function upload hinh anh trả về rỗi nếu ng dùng ko up ảnh
   function UploadAnh1(){
	// duong dan den file anh
   	$linkMucUpload=getUrl('public/image/');

   	if ($_FILES[$this->filename]['name']!=NULL) {

        //phần config upload hình ảnh
   		if (isset($_FILES[$this->filename]))
   		{
            // Nếu file upload không bị lỗi,
            // Tức là thuộc tính error > 0
   			if ($_FILES[$this->filename]["type"] != 'image/jpeg' && $_FILES[$this->filename]['type'] != 'image/png') {
   				return $this->error= "bạn chỉ được upload file dưới dạng PNG và JPEG";
   			}elseif ($_FILES[$this->filename]['size']>2*1024*1024) {
   				return $this->error="bạn chỉ được tải lên file >2 MB";
   			}
   			else{
                // Upload file
   				move_uploaded_file($_FILES[$this->filename]['tmp_name'], "$linkMucUpload".$_FILES[$this->filename]['name']);
   				$imaup['anh']=$_FILES[$this->filename]['name'];
                // echo 'File Uploaded Thành Công';
   			}
   		}else{
   			return $this->imgupload='';
   		}

   	}else{
   		return $this->imgupload='';
   	}  

       return $this->imgupload=$imaup['anh'];//trả về giá trị imgname nếu mấy kq thì gọi từ biến hứng đên imgname

       //lấy thông báo lỗi bằng cách trỏ đến error

   }






// function upload nhiều anh với điều kiện đặt số lần lặp bằng $i
   function UploadAnhs2(){
// public namefile
// public i bien lap
// return anhuploads
   	if ($_FILES[$this->namefile]['name'][$this->i] !=NULL) {
   		if (isset($_FILES[$this->namefile]))
   		{
            // Nếu file upload không bị lỗi,
            // Tức là thuộc tính error > 0
   			if ($_FILES[$this->namefile]['type'][$this->i] != 'image/jpeg' && $_FILES[$this->namefile]['type'][$this->i] != 'image/png') {
   				return $this->error= "bạn chỉ được upload file dưới dạng PNG và JPEG";
   			}elseif ($_FILES[$this->namefile]['size'][$this->i]>2*1024*1024) {
   				return $this->error= "bạn chỉ được tải lên file >2 MB";
   			}
   			else{
                // Upload file
   				move_uploaded_file($_FILES[$this->namefile]['tmp_name'][$this->i] ,'image/'.$_FILES[$this->namefile]['name'][$this->i] );
   				$imaup['ok']=$_FILES[$this->namefile]['name'][$this->i];
                // echo 'File Uploaded Thành Công';
   			}
   		}
   	}
         return $this->anhuploads=$imaup['ok'];//trả về giá trị imgname nếu mấy kq thì gọi từ biến hứng đên imgname
        	//nếu không gặp lỗi thì tiến hanhf insert vào db
         
     }

    



}
// $md=BaseModel::whereAndwhereLimit(['id','1','idTheLoai','1','0','16']);
// var_dump($md);
?>
