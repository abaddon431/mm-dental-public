<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';
include_once '../../classes/autoloader.php';

if(isset($_POST["resetsubmit"]))
{ 
    $create_token=new DBOpController();


    $selector=bin2hex(random_bytes(8));
    $token=random_bytes(32);
    // CHANGE THIS -- Directory
    $url="ROOT_DIRECTORY/admin/includes/create-pass.php?selector=".$selector."&validator=".bin2hex($token);

    $expires=date("U")+360; //expires after 5 minutes;
    $email=$_POST['resetemail'];
    $hashtoken=password_hash($token,PASSWORD_BCRYPT);
    
    echo $create_token->create_token($email,$selector,$hashtoken,$expires);

    //send mail
    // CHANGE THIS -- ALL INPUT ALLCAPS
    $sender='SENDEREMAIL';
    $sender_pass='SENDERPASSWORD';
    $mail=new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPAuth=true;
    $mail->SMTPDebug  = 1;
    //for using domain
    $mail->SMTPSecure='tls';
    $mail->Host='SENDER_EMAILSERVER';
    //for using gmail
    // $mail->SMTPSecure="ssl";
    // $mail->Host='smtp.gmail.com';
    $mail->Port='587'; //465
    $mail->isHTML();
    
    $mail->Username=$sender;
    $mail->Password=$sender_pass;
    $mail->SetFrom('SENDEREMAIL','SENDERNAME');
    $mail->Subject='Password Reset Link';
    $message="<p>We received a password reset requests. The link to reset your password is below. If you did not made this request, you can ignore this message</p>";
    $message.="<p>Reset Link:</br>";
    $message.='<a href="'.$url.'" >'.$url.'</a></p><br><strong>This link expires in 5 minutes</strong>';
    $mail->Body=$message;
    $mail->AddAddress($email);

    $mail->Send();

    header("location:../password-reset-form.php?reset=success");
}
else
{
    header("location:../login.php");
}



