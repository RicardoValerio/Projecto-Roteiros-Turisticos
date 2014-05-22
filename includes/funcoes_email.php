<?php

function enviaEmail($subject, $body, $email_destinatario, $username_destinatario) {
    require_once 'phpMailer/class.phpmailer.php';
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Mailer = 'smtp';
    $mail->SMTPAuth = true;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    $mail->Username = USERNAME_EMAIL;
    $mail->Password = PASSWORD_EMAIL;
    $mail->IsHTML(true);
    $mail->SingleTo = true;
    $mail->From = USERNAME_EMAIL;
    $mail->FromName = NOME_EMPRESA;
    $mail->addAddress($email_destinatario, $username_destinatario);
    $mail->AddEmbeddedImage("img/logo_email.jpg", "logo", "img/logo_email.jpg");
    $mail->Subject = $subject;
    $mail->Body = $body;
    if (!$mail->Send()) {
        return false;
    } else {
        return true;
    }
}

?>
