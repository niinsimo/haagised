<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

if(isset($_POST['smbbtn'])){
	$start = $_POST['start'];
	$end = $_POST['end'];

	$mail = new PHPMailer(true);
	try{
		$mail->isSMTP();
		$mail->SMTPAuth = 'true';
		$mail->SMTPSecure = "tls";
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = '587';
		$mail->isHtml();
		$mail->Username = 'test.test6784636@gmail.com';
		$mail->Password = 'test1234!';
		$mail->SetFrom('no-reply@trailer.com');
		$mail->Subject = 'Haagis on broneeritud!';
		$mail->Body = 'Tere hea haagisrendi veebikülje kasutaja!. Te olete meie veebileheküljelt rentinud haagise ajavahemikus  '. $start . " kuni " . $end;
		$mail->AddAddress($_SESSION['email']);
		$mail->Send();
		echo 'Message has been sent';
	} catch (Exception $e) {
		echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
	}
}




?>



<html lang="et">
<head>
<meta charset="utf-8">
<style>
.header{
	display: block;
	text-align:center;
	background:yellow;
}
</style>
</head>
<body>
<div class = "header">
	<h1>Broneeri endale haagis, <?php session_start(); echo $_SESSION['username'];?></h1>
	<a href = "upload.php">Vaata haagiseid</a>
	
</div>
<h2>Millisel ajavahemikul soovid haagist broneerida, <?php echo $_SESSION['username'];?> ?</h2>
<form method = "post">
	Algusaeg:<input type = "date" name = "start">
	Lõppaeg:<input type = "date" name = "end">
	<input type = "submit" name = "smbbtn" value = "Kinnita">
</form>