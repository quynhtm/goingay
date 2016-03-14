<?php
class System {
    static function sendSVEmail($to, $subject, $content, $FromNameMail='Save.vn', $charset='utf-8', $images = array()){
    	
    	//if($_SERVER['HTTP_HOST'] == 'localhost') return true;
        require_once(ROOT_PATH.'includes/enbac/mailer/class.phpmailer.php');
        $mail = new PHPMailer();
        $mail->CharSet = $charset;
        $mail->IsSMTP();
        $mail->SetLanguage("vn",ROOT_PATH.'includes/enbac/mailer/');
        $mail->Host    = "192.168.4.21";
        $mail->Port     = 25;
        $mail->SMTPAuth = true;
        $mail->Username = "wiki@solo.vn";    	// SMTP username
        $mail->Password = "aggsd3233ies";                 // SMTP password
        $mail->From    = "support@solo.vn";        // Email duoc gui tu???
        $mail->FromName = "Save.vn";                // Ten hom email duoc gui
        $mail->AddAddress($to,"");                    // Dia chi email va ten nhan
        
        if(!empty($images)){
            $mail->message_type = 'attachments';
            foreach($images as $img){
                if(!empty($img)){
                    $img['mime'] = 'image/'.EnBacLib::getExtension($img['src']);
                    $mail->AddEmbeddedImage($img['src'], $img['id'], $img['title'], 'base64', $img['mime']);
                }
            }
            //cau hinh nhu sau <img src="cid:ubzsed" />
        }
        $mail->IsHTML(true);                        // Gui theo dang HTML
        $mail->Subject  =  $subject;                // Chu de email
        $mail->Body    =  $content;                // Noi dung html
        if(!$mail->Send()){return false;}else{return true;}
             
    }
   
    static function halt(){
        exit();
    }
   
    static function debug($array){
        echo '<div align="left"><pre>';
        print_r($array);
        echo '</pre></div>';
    }
}