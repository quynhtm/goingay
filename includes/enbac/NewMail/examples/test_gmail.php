<?php
error_reporting(E_ALL);
//error_reporting(E_STRICT);

//date_default_timezone_set('America/Toronto');
date_default_timezone_set('Asia/Bangkok');

require_once("../class.phpmailer.php");
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

$mail             = new PHPMailer();

$body             = $mail->getFile('contents.html');
$body             = eregi_replace("[\]",'',$body);

$mail->IsSMTP();
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Port       = 465;                   // set the SMTP port for the GMAIL server

$mail->Username   = "mrtuannk@gmail.com";  // GMAIL username
$mail->Password   = "ádfádf";            	// GMAIL password

$mail->AddReplyTo("mrtuannk@gmail.com","Tuan Nguyen");

$mail->From       = "tuannk@enbac.com";
$mail->FromName   = "TuanNK";

$mail->Subject    = "Hi sir!";

//$mail->Body       = "Hi,<br>This is the HTML BODY<br>";                      //HTML Body
$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
$mail->WordWrap   = 50; // set word wrap

$mail->MsgHTML($body);

//$mail->AddAddress("whoto@otherdomain.com", "John Doe");
$mail->AddAddress("mrtuannk@gmail.com","Tuan Nguyen");

//$mail->AddAttachment("images/phpmailer.gif");             // attachment

$mail->IsHTML(true); // send as HTML

if(!$mail->Send()){
  echo "Mailer Error: " . $mail->ErrorInfo;
} 
else{
  echo "Message sent!";
}
?>
