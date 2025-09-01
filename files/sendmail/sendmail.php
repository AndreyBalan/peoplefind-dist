<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'phpmailer/src/Exception.php';
	require 'phpmailer/src/PHPMailer.php';
	require 'phpmailer/src/SMTP.php';

	$mail = new PHPMailer(true);
	$mail->CharSet = 'UTF-8';
	$mail->setLanguage('ru', 'phpmailer/language/');
	$mail->IsHTML(true);

	/*
	$mail->isSMTP();                                            //Send using SMTP
	$mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
	$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
	$mail->Username   = 'user@example.com';                     //SMTP username
	$mail->Password   = 'secret';                               //SMTP password
	$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
	$mail->Port       = 465;                 
	*/

//Від кого лист
	$mail->setFrom('from@gmail.com', ''); // Вказати потрібний E-mail
	//Кому відправити
	$mail->addAddress('info@bellumaco.ltd'); // Вказати потрібний E-mail
	//Тема листа
	$mail->Subject = 'Вітання!';

	//Тіло листа
	$body = '<h1>Вам було надіслано форму з сайту People Find.</h1>';

	if(trim(!empty($_POST['name']))){
		$body.= "<p><strong>Name:</strong> ".$_POST['name']. "</p>";
	}	
	if(trim(!empty($_POST['surname']))){
		$body.= "<p><strong>Surname:</strong> ".$_POST['surname']. "</p>";
	}	
	if(trim(!empty($_POST['email']))){
		$body.= "<p><strong>Email:</strong> ".$_POST['email']. "</p>";
	}	
	if(trim(!empty($_POST['phone']))){
		$body.= "<p><strong>Phone:</strong> ".$_POST['phone']. "</p>";
	}	
	
	
	//Прикріпити файл
	if (!empty($_FILES['attachment']['tmp_name'])) {
		//шлях завантаження файлу
		$filePath = __DIR__ . "/files/sendmail/attachments/" . $_FILES['attachment']['name']; 
		//грузимо файл
		if (copy($_FILES['attachment']['tmp_name'], $filePath)){
			$fileAttach = $filePath;
			$body.='<p><strong>Файл у додатку</strong>';
			$mail->addAttachment($fileAttach);
		}
	}
	

	$mail->Body = $body;

	//Відправляємо
	if (!$mail->send()) {
		$message = 'Помилка';
	} else {
		$message = 'Дані надіслані!';
	}

	$response = ['message' => $message];

	header('Content-type: application/json');
	echo json_encode($response);
?>