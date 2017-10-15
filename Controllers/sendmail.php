<?php 

function SendMail(){
// public email
// public name
// public TieuDe
// public NoiDung

require_once 'lib/PHPMailer/src/Exception.php';
require_once 'lib/PHPMailer/src/PHPMailer.php';
require_once 'lib/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
$mail = new PHPMailer(true);

$email_from = 'buiduc1998@gmail.com'; // email gui va nhan reply
$name_from = 'duc dz';
//Send mail using gmail
// if($send_using_gmail){
    $mail->IsSMTP(); // telling the class to use SMTP
    $mail->SMTPAuth = true; // enable SMTP authentication
    $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
    $mail->Host = "smtp.gmail.com"; // sets GMAIL as the SMTP server
    $mail->Port = 465; // set the SMTP port for the GMAIL server
    $mail->Username = "ducpoly10@gmail.com"; // GMAIL username
    $mail->Password = "11556677"; // GMAIL password
// }
 
//Typical mail data
$mail->AddAddress($this->email, $this->name);
$mail->SetFrom($email_from, $name_from);
$mail->Subject = $this->TieuDe;
$mail->Body = $this->NoiDung;
// $mail->addAttachment('./uploads/img1.jpg'); 
 
try{
    $mail->Send();
    return $notification="Success";
} catch(Exception $e){
    //Something went bad
    return $notification="Fail";
}
 }

 ?>