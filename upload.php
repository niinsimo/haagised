
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
$query = "SELECT trailername, trailerdesc FROM trailerinfo";
$result = $mysqli->query($query);

$target_dir = "profilepics/";
$test = scandir($target_dir);
$array = array_diff($test, [".", ".."]);
$loendur = 1;
foreach($array as $image){
	$files = $target_dir . $test[1+ $loendur];
	$loendur = $loendur +1;
	echo "<br><img src ='$files'><br>";
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
        echo "Haagise nimi: ". $row["trailername"]. "<br> Haagise kirjeldus: ". $row["trailerdesc"]. "<br>";
}

}

//http://greeny.cs.tlu.ee/~lahtsten/haagised_too/haagised/profilepics/rtukunn.png
?>

