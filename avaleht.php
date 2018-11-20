<?php
$target_dir = "/../";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
if(isset($_POST["submit"])){
	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
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
	<h1>Tere tulemast haagisterendilehele <?php session_start(); echo $_SESSION['username']; ?>
	
</div>
<a href= "upload.php">
<input name= "addtrailer" type = "button" value ="Lisa haagis" href ="upload.php"></input>
</a>
<form action="upload.php" method="post" enctype="multipart/form-data">
    Select image to upload:
    <input type="file" name="fileToUpload" id="fileToUpload">
    <input type="submit" value="Upload Image" name="submit">
</form>