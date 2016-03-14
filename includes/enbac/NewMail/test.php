<?php
error_reporting(E_ALL);

date_default_timezone_set('Asia/Bangkok');
require_once("class.phpmailer.php");
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail             = new PHPMailer();

$body             = $mail->getFile('contents.html');
$body             = eregi_replace("[\]",'',$body);

$mail->IsSMTP();
$mail->SMTPAuth   = true;                  // enable SMTP authentication
//$mail->SMTPSecure = "ssl";               // sets the prefix to the server (use for Gmail)

$mail->Host       = "mail.enbac.com";      // sets email as the SMTP server
$mail->Port       = 25;                   // set the SMTP port for the email server

$mail->Username   = "no-reply@enbac.com";  // email username
$mail->Password   = "123enbac654";            	// email password

$mail->AddReplyTo("no-reply@enbac.com","Enbac.com");

$mail->From       = "no-reply@enbac.com";
$mail->FromName   = "Enbac.com";

$mail->CharSet    = "utf-8";
$mail->Subject    = "[ Enbac.com ] Thông tin giao dịch!";

//$mail->Body       = "Hi,<br>This is the HTML BODY<br>";                      //HTML Body
$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
$mail->WordWrap   = 50; // set word wrap

$mail->MsgHTML($body." Test fát nữa nhá, ối zời ơi là zời :X");

$mail->AddAddress("mrtuannk@gmail.com","Tuan Nguyen");

//$mail->AddAttachment("images/phpmailer.gif");// attachment

$mail->IsHTML(true); // send as HTML

if(!$mail->Send()){
  echo "Mailer Error: " . $mail->ErrorInfo;
} 
else{
  echo "Message sent!";
}
?>
