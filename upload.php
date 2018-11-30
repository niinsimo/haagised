
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
</head>
<body>
<style>
.header{
	display: block;
	text-align:center;
	background:yellow;
}
</style>
<div class = "header">
	<h1>Siin näed saadavalolevaid haagiseid, <?php session_start(); echo $_SESSION['username'];?></h1>
	<a href = "avaleht.php">Tagasi avalehele</a>
	
</div>
</body>
</html>

<?php
require "../../../config.php";
if(!isset($_SESSION['username'])){
	header('Location: frontpage.php');
}
$database = "if17_lahtsten";
$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
$query = " SELECT FirstName, LastName, trailerinfo.trailername, trailerinfo.trailerdesc, trailerinfo.trailerpic, trailerusers.Email FROM trailerusers INNER JOIN trailerinfo ON trailerusers.Email = trailerinfo.Email";
$result = $mysqli->query($query);
$result_rows = $result->num_rows;
for($x = 0; $x<$result_rows; $x++){
	if ($result_rows > 0) {
		$row = $result->fetch_assoc();
		$trname = $row['trailername'];
		echo "<br><img src =". $row['trailerpic']. " id = " . str_replace(' ', '_', $row['trailername']) ."><br>";
		echo "Üleslaadija: ". $row["FirstName"] . " " . $row["LastName"] . "<br>  Haagise nimi: ". $row["trailername"]. "<br> Haagise kirjeldus: ". $row["trailerdesc"]. "<br>";
		echo "<form method='post'><input type = 'submit' value = 'Broneeri' name = " .str_replace(' ', '_', $row['trailername']) . "> </form>";
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

?>

