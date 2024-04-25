<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('ru', 'phpmailer/language/');
$mail->IsHTML(true);

// От кого письмо
$mail->setForm('shadow_9009@mail.ru', 'Фрилансер - ученик');
// Кому отправить
$mail->addAddress('litvinenkoevgeniy3359@gmail.com');
// Тема письма
$mail->Subject = 'Привет!!! Это Фрилансер - ученик'

// Рука
$hand="Правая";
if(@_POST['hand']=="left"){
	$hand = "Левая"
}

// Тело письма
$body = '<h1>Встречай супер письмо!</h1>';

if(trim(!empty($_POST['name']))){
	$body.='<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
}
if(trim(!empty($_POST['email']))){
	$body.='<p><strong>Email:</strong> '.$_POST['email'].'</p>';
}
if(trim(!empty($_POST['hand']))){
	$body.='<p><strong>Рука:</strong> '.$hand.'</p>';
}
if(trim(!empty($_POST['age']))){
	$body.='<p><strong>Возраст:</strong> '.$_POST['age'].'</p>';
}
if(trim(!empty($_POST['message']))){
	$body.='<p><strong>Сообщение:</strong> '.$_POST['message'].'</p>';
}

// Прикрепить файл
if(!empty($_FILES['image'],['tmp_name'])){
	// путь загрузчика файла
	$filePath =__DIR__ . "/files/" . $_FILES['image']['name'];
	// загрузим файл
	if(copy($_FILES['image']['tmp_name'],$filePath)){
		$fileAttach = $filePath;
		$body.='<p><strong>Фото в приложении</strong>';
		$mail->addAttach($fileAttach);
	}
}

$mail->Body = $body;

// Отправка письма
if(!$mail->send()){
	$message = 'Ошибка';
} else {
	$message = 'Письмо отправлено';
}

$response = ['message' => $message];
header ('Content-Type: application/json');
echo json_encode($response);
?>