<?php
$target_dir = "profilepics/";
$uploadOk = 1;
$nameError = "";
$commentError = "";
require "../../../config.php";
if(isset($_POST["submit"])){
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		} else {
			echo "Sorts, midagi läks valesti";
		}
	session_start();
	$database = "if17_lahtsten";
	$trailerName = $_POST['trailerName'];
	$trailerDesc = $_POST['comment'];
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$query = $mysqli->prepare ("INSERT INTO trailerinfo(trailername, trailerpic, trailerdesc, Email) VALUES (?,?,?,?)");
	echo $mysqli->error;
	$query->bind_param("ssss", $trailerName, $target_file, $trailerDesc, $_SESSION['email']);
	if($query->execute()){
	}else{
		echo "Tekkis viga!" . $query->error;
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
	<h1>Tere tulemast haagisterendilehele <?php session_start(); echo $_SESSION['username'];?>
	
</div>
<a href= "upload.php">
<input name= "addtrailer" type = "button" value ="Vaata haagiseid" href ="upload.php"></input>
</a>
<form action = "upload.php" method="post" enctype="multipart/form-data">
	<input type = "text" placeholder = "Haagise nimi" name = "trailerName">
	<br>
	<textarea name= "comment" rows = "5" cols = "40" placeholder = "Tehnilised spetsifikatsioonid" ></textarea>
	<br>
    Vali pilt, mida üles laadida:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Lae haagis üles" name="submit">
</form>
<a href = "mydata.php">Minu andmed</a>