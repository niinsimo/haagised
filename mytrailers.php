<html lang="et">
<head>
<meta charset="utf-8">
<style>
<?php ob_start(); include 'css/main.css'; ?>
</style>
</head>
<body>
<?php session_start(); include("header.php"); ?>

<div class = "header">
	<h1 class = "h1">Siin näed enda üleslaetud haagiseid, <?php echo $_SESSION['username'];?>.</h1>
	

<?php
require "../../config.php";
if(!isset($_SESSION['username'])){
	header('Location: frontpage.php');
}
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
		echo "<div class='addTrailerContainer'><div class = 'addTrailer'>Haagise nimi: " . $row['trailername'] . "<br><br><form method = 'post' enctype ='multipart/form-data' ><input type = 'text' name = 'chname" .$loendur ."' placeholder = 'Muuda nime'><div class = 'upload-btn-wrapper'><input type= 'submit' name ='submitname" . $loendur ."' value = 'Muuda'></div></form><br>Haagise kirjeldus: " . $row['trailerdesc'] . "<br><br><form method = 'post' enctype = 'multipart/form-data'><textarea name= 'chdesc" . $loendur ."' placeholder = 'Muuda kirjeldust' rows = '5' cols = '40'>" . $row['trailerdesc'] . "</textarea><div class = 'upload-btn-wrapper'><input type = 'submit' name = 'submitdesc" . $loendur ."' value = 'Muuda'></form></div></div></div>";
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
<?php
include("footer.php");
?>
<div id="myModal" class="modal">
	<div class="modal-content">
		<span class="close">&times;</span>
		<p><?php 
		require "../../config.php";
		$database = "if17_lahtsten";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$query = "SELECT FirstName, LastName, Adress FROM trailerusers WHERE Email = '" . $_SESSION['email'] . "' ";
		$result = $mysqli->query($query);
		if ($result->num_rows > 0) {
			while($row = $result->fetch_assoc()) {
				echo "Eesnimi: ". $row["FirstName"] . "</br>"; 
				echo "Perenimi: ". $row["LastName"]. "</br>";
				echo "Aadress: " . $row["Adress"] . "<form method = 'post'><input name = 'changeAdress' type='text' placeholder = 'Muuda aadressi'><input name = 'changeButton' type='submit' value = 'Muuda'></form> <br>";
			}
		} else {
			echo "Midagi läks valesti!";
		}
		if(isset($_POST['changeButton'])){
			$adress = $_POST['changeAdress'];
			$query = "UPDATE trailerusers SET Adress ='$adress' WHERE Email = '" . $_SESSION['email'] . "' ";
			$result = $mysqli->query($query);
			header('Location: '.$_SERVER['PHP_SELF']);
		}
	
	
	?>
		
		</p>
	  </div>

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
