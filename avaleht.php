<?php
$target_dir = "profilepics/";
$uploadOk = 1;
$nameError = "";
$commentError = "";
session_start();
if(!isset($_SESSION['username'])){
	header('Location: frontpage.php');
}
require "../../config.php";
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
	$database = "if17_lahtsten";
	$trailerName = $_POST['trailerName'];
	$trailerDesc = $_POST['comment'];
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$query = $mysqli->prepare ("INSERT INTO trailerinfo(trailername, trailerpic, trailerdesc, Email) VALUES (?,?,?,?)");
	echo $mysqli->error;
	$query->bind_param("ssss", $trailerName, $target_file, $trailerDesc, $_SESSION['email']);
	if($query->execute()){
		header('Location: upload.php');
	}else{
		echo "Tekkis viga!" . $query->error;
	}
}
if(isset($_POST["logout"])){
	session_unset();
	header("Location: frontpage.php");
}
$database = "if17_lahtsten";
$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
$email = $_SESSION['email'];
$query = "SELECT * FROM trailerinfo WHERE Email =  '$email'";
$result = $mysqli->query($query);
$result_rows = $result->num_rows;
	
	


?>

<html lang="et">
<head>
<meta charset="utf-8">
<style>
<?php include 'css/main.css'; ?>
</style>
</head>
<body>
<?php include("header.php"); ?>

<div class = "header">
	<?php
	$folder = str_replace(' ', '_', $_SESSION['username']) . "_" . $_SESSION['id'] . "/";
	
	if(file_exists("$folder")){
		$file = scandir($folder);
		$_SESSION['file'] = $folder . $file[2];
		if(isset($_POST['submitbtn'])){
			$files = glob("./" . $folder ."/*");
			foreach($files as $file){
				if(is_file($file)){
					unlink($file);
				}
			}
			$target_file = $folder . basename($_FILES["fileToUpload2"]["name"]);
			$_SESSION['file'] = $target_file;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			$check = getimagesize($_FILES["fileToUpload2"]["tmp_name"]);
			if($check !== false) {
				$uploadOk = 1;
			} else {
				echo "File is not an image.";
				$uploadOk = 0;
			}

			if (move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_file)) {
				} else {
					echo "Sorts, midagi läks valesti";
				}
			
		}
	}
	if(!file_exists("$folder")){
		if(isset($_POST['submitbtn'])){
			mkdir($folder, 0777);
			$target_file = $folder . basename($_FILES["fileToUpload2"]["name"]);
			$_SESSION['file'] = $target_file;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			$check = getimagesize($_FILES["fileToUpload2"]["tmp_name"]);
			if($check !== false) {
				$uploadOk = 1;
			} else {
				echo "File is not an image.";
				$uploadOk = 0;
			}

			if (move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_file)) {
				} else {
					echo "Sorts, midagi läks valesti";
				}
			
		}
	}
	
		
	if(file_exists("$folder")){
		chmod($folder, 0777);
		echo "<img class='profile-pic resize' src =" . $_SESSION['file'] . "><br>";
	}
	
	
	?>
	<h1 class="username"><?php echo $_SESSION['username'];?></h1>
	<div class= "container">
		<ul>
			<li><p>Minu Haagised: </p><a><?php echo $result_rows;?></a></li>
			<li><p>Minu keskmine hinne: </p><a><?php echo $result_rows;?></a></li>
			<li><p>Renditud haagiseid: </p><a><?php echo $result_rows;?></a></li>
		</ul>
	</div>
</div>
<div class="addTrailerContainer">
	<div class="addTrailer">
		<h2>Lisa enda haagis</h2>
		<form method="post" enctype="multipart/form-data">
			<input type = "text" placeholder = "Haagise nimi" name = "trailerName">
			<br>
			<textarea name= "comment" rows = "5" cols = "40" placeholder = "Tehnilised spetsifikatsioonid" ></textarea>
			<br>
		   Vali haagis, mida üles laadida:
			<input type="file" name="fileToUpload" id="fileToUpload">
			<input type="submit" value="Lae haagis üles" name="submit">
		</form>
	</div>
	<div class="addTrailer">
		<a href = "mydata.php">Minu andmed</a>
		<form method = "post" enctype="multipart/form-data">
			<input type="file" name="fileToUpload2" id="fileToUpload2">
			<input type="submit" value="Uuenda profiilipilti" name="submitbtn">
		</form>
		<form method="post" enctype="multipart/form-data">
			<input name = "logout" type = "submit" value = "Logi välja">
		</form>
	</div>
</div>

