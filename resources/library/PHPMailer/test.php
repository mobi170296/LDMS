<?php

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer(true);

try{
	$mail->SMTPDebug = 0;
	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'mobi170296@gmail.com';
	$mail->Password = 'not valid';
	$mail->SMTPSecure = 'tls';
	$mail->Port = 587;
	$mail->setFrom('mobi70296@gmail.com', 'Hệ thống quản lý công văn');
	$mail->addAddress('linh17021996@gmail.com');
	$mail->CharSet = 'UTF-8';
	$mail->isHTML(true);
	$mail->Subject = 'Tiêu đề thư';
	$mail->Body = 'Nội dung thư';
	$mail->send();
	echo 'Đã gửi';
}catch(Exception $e){
	echo 'Lỗi: ' . $mail->ErrorInfo;
}