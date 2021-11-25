<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require '/opt/lampp/htdocs/AW/src/vendor/autoload.php'; 


function enviarEmail($email, $nome, $mensagem, $assunto, $email_resposta=null) {

if ($email_resposta) {
	$email_resposta = $_POST['email_resposta'];
}

$mail = new PHPMailer();
$mail->isSMTP();
$mail->SMTPDebug = 1;
$mail->SMTPAuth = true;

$mail->Host = 'smtp.mailtrap.io';
// $mail->SMTPOptions = [
  //      'ssl' => [
    //          'verify_peer' => false,
    //          'verify_peer_name' => false,
    //          'allow_self_signed' => true,
    //     ]
    // ];
    
$mail->Username = '7c73252f3b2703';
$mail->Password = '161a2c0cea727d';
$mail->Port = 2525;
$mail->SMTPSecure = 'tls';

$mail->setFrom('confirmaremail@dev.com','Adm Site');
$mail->addAddress($email, $nome );
$mail->CharSet = "utf-8";
$mail->addReplyTo($email_resposta);
$mail->Subject = $assunto;
$mail->Body = $mensagem;
$mail->isHTML(true);
// $mail->AddEmbeddedImage('email/logo.png', 'logo_ref');

if (!$mail->send()) {
    $retorno = false;
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    return $mensagem;
}

return $retorno;

}
?>