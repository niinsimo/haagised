<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
</head>
<body>
<style>
<?php ob_start(); include 'css/main.css'; ?>
</style>
<?php session_start(); include("header.php"); ?>
</body>
</html>

<?php
require "../../config.php";
if(!isset($_SESSION['username'])){
	header('Location: frontpage.php');
}

$database = "if17_lahtsten";
$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
$sessEmail = $_SESSION['email'];
$query = " SELECT FirstName, LastName, trailerinfo.trailername, trailerinfo.trailerdesc, trailerinfo.trailerpic, trailerusers.Email FROM trailerusers INNER JOIN trailerinfo ON trailerusers.Email = trailerinfo.Email WHERE trailerinfo.Email <> '$sessEmail'";
$result = $mysqli->query($query);
$result_rows = $result->num_rows;
for($x = 0; $x<$result_rows; $x++){
	if ($result_rows > 0) {
		$row = $result->fetch_assoc();
		$trname = $row['trailername'];
		echo "<div class = 'trailersContainer'><div class = 'addTrailer'><br><br><img src =". $row['trailerpic']. " width = '300' height = '200' id = " . str_replace(' ', '_', $row['trailername']) ."><br>";
		echo "Üleslaadija: ". $row["FirstName"] . " " . $row["LastName"] . "<br>  Haagise nimi: ". $row["trailername"]. "<br> Haagise kirjeldus: ". $row["trailerdesc"]. "";
		echo "<form method='post'><div class = 'upload-btn-wrapper'><input type = 'submit' value = 'Broneeri' name = " .str_replace(' ', '_', $row['trailername']) . "> </form></div></div></div>";
		$corstr = str_replace(' ', '_', $row['trailername']);
		if(isset($_POST["$corstr"])){
			$fname = $row['FirstName'];
			$lname = $row['LastName'];
			$trname = $row['trailername'];
			$userEmail = $row['Email'];
			$_SESSION['trailername'] = $trname;
			$_SESSION['fname'] = $fname;
			$_SESSION['lname'] = $lname;
			$_SESSION['meil'] = $row['Email'];
			header("Location: broneering.php");
		}
			
			
			
	}
}
if(isset($_POST['submit'])){
	session_unset();
	header("Location:frontpage.php");
}
include 'footer.php';
?>

