
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
$query = "SELECT trailername, trailerdesc, trailerpic FROM trailerinfo";
//$query2 = "SELECT "
$result = $mysqli->query($query);
$result_rows = $result->num_rows;
for($x = 0; $x<$result_rows; $x++){
	if ($result_rows > 0) {
		$row = $result->fetch_assoc();
		$trname = $row['trailername'];
		echo "<br><img src =". $row['trailerpic']. " id = " . str_replace(' ', '_', $row['trailername']) ."><br>";
		echo "Haagise nimi: ". $row["trailername"]. "<br> Haagise kirjeldus: ". $row["trailerdesc"]. "<br>";
		echo "<form method='post'><input type = 'submit' value = 'Broneeri' name = " .str_replace(' ', '_', $row['trailername']) . "> </form>";
		$corstr = str_replace(' ', '_', $row['trailername']);
		if(isset($_POST["$corstr"])){
			$trname = $row['trailername'];
			$_SESSION['trailername'] = $trname;
			header("Location: broneering.php");
		}
			
			
	}
}

//http://greeny.cs.tlu.ee/~lahtsten/haagised_too/haagised/profilepics/rtukunn.png
?>

