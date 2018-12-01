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
	<h1>Siin näed enda üleslaetud haagiseid, <?php session_start(); echo $_SESSION['username'];?>.</h1>
	<a href = "avaleht.php">Tagasi avalehele</a>
	<form method = "post" enctype "multipart/form-data">
		<input type = "submit" name = "submit" value = "Logi välja">
	</form>
</div>
<?php
require "../../../config.php";
$database = "if17_lahtsten";
$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
$email = $_SESSION['email'];
$query = "SELECT trailername, trailerdesc, trailerpic FROM trailerinfo WHERE Email ='$email'";
$result = $mysqli->query($query);
$result_rows = $result->num_rows;
$loendur = 0;
for($x = 0; $x<$result_rows; $x++){
	$loendur = $loendur +1;
	if($result_rows>0){
		$row = $result->fetch_assoc();
		$_SESSION['trname'] = $row['trailername'];
		echo "<img src= " . $row['trailerpic'] . "><br>";
		echo "Haagise nimi: " . $row['trailername'] . "<br> Haagise kirjeldus: " . $row['trailerdesc'] . "<br><form method = 'post' enctype ='multipart/form-data' ><input type = 'text' name = 'chname" .$loendur ."' placeholder = 'Muuda nime'><input type= 'submit' name ='submitname" . $loendur ."' value = 'Muuda'></form><br><form method = 'post' enctype = 'multipart/form-data'><textarea name= 'chdesc" . $loendur ."' placeholder = 'Muuda kirjeldust' rows = '5' cols = '40'>" . $row['trailerdesc'] . "</textarea><input type = 'submit' name = 'submitdesc" . $loendur ."' value = 'Muuda'></form>";
		$email = $_SESSION['email'];
		$newsbmname = "submitname" . $loendur;
		$newsbmdesc = "submitdesc" .$loendur;
		
		
		if(isset($_POST[$newsbmname])){
			$newtxtname = "chname" .$loendur;
			$oldtr = $row['trailername'];
			$newtrname = $_POST[$newtxtname];
			$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);			
			$query = "UPDATE trailerinfo SET trailername ='$newtrname' WHERE trailername ='$oldtr'";
			$result = $mysqli->query($query);
			header('Location: '.$_SERVER['PHP_SELF']);
		}
		if(isset($_POST[$newsbmdesc])){
			$newtxtdesc = "chdesc" .$loendur;
			$olddesc = $row['trailerdesc'];
			$newtrdesc = $_POST[$newtxtdesc];
			$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
			$query = "UPDATE trailerinfo SET trailerdesc='$newtrdesc' WHERE trailerdesc= '$olddesc'";
			$result = $mysqli->query($query);
			header('Location: '.$_SERVER['PHP_SELF']);
		}
			
			
	}else{
		echo "Vabandust midagi läks valesti!";
	}
}
if(isset($_POST['submit'])){
	session_unset();
	header("Location:frontpage.php");
}



?>

