<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
session_start();

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
		$mail->Body = 'Tere hea haagisrendi veebikülje kasutaja!. Te olete meie veebileheküljelt rentinud haagise ' . $_SESSION['trailername'] . ' ajavahemikus  '. $start . " kuni " . $end;
		$mail->AddAddress($_SESSION['email']);
		$mail->Send();
		echo 'Message has been sent';
	} catch (Exception $e) {
		echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
	}
}
if(isset($_POST['submit'])){
	session_unset();
	header("Location:frontpage.php");
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
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
</style>
</head>
<body>
<div class = "header">
	<h1>Broneeri endale haagis, <?php echo $_SESSION['username'];?></h1>
	<a href = "upload.php">Vaata haagiseid</a>
	<form method = "post" enctype = "multipart/form-data">
		<input type = "submit" name = "submit" value = "Logi välja">
	</form>
	
</div>
<h2>Millisel ajavahemikul soovid rentida kasutajale <?php echo $_SESSION['fname'] . " " . $_SESSION['lname'];?> kuuluvat haagist <?php echo $_SESSION['trailername'];?> ?</h2>
<form method = "post">
	Algusaeg:<input type = "date" name = "start">
	Lõppaeg:<input type = "date" name = "end">
	<input type = "submit" name = "smbbtn" value = "Kinnita">
</form>
<button id="myBtn">Vaata kasutaja täpsemaid andmeid</button>
<div id="myModal" class="modal">
	<div class="modal-content">
    <span class="close">&times;</span>
    <p><?php 
	require "../../../config.php";
	$database = "if17_lahtsten";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$eMail = $_SESSION['meil'];
	$query = "SELECT FirstName, LastName, Email, Adress FROM trailerusers WHERE Email = '$eMail'";
	$result = $mysqli->query($query);
	$row = $result->fetch_assoc();
	$result_rows = $result->num_rows;
	if($result_rows > 0){
		echo "Haagise omanik: " . $row["FirstName"] . " " . $row["LastName"] . "<br> Omaniku e-mail: " . $row["Email"] . "<br> Omaniku aadress: " . $row["Adress"]; 
	}
	
	
	?>
	
	</p>
  </div>

</div>
<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
</script>
</body>