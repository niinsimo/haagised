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
<div class = "search">
	<form method = "post" enctype = "multipart/form-data">
		<select name="values">
			<option value="haagis">Haagise nimi</option>
			<option value="omanik">Omaniku nimi</option>
		</select>
		<input type = "text" name = "otsing">
		<input type = "submit" value = "Otsi" name ="search">
		
		
	</form>
</div>
<div class = "header">
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
					echo "<h3>Eesnimi: ". $row["FirstName"] . "</h3></br>"; 
					echo "<h3>Perenimi: ". $row["LastName"]. "</h3></br>";
					echo "<h3>Aadress: " . $row["Adress"] . "</h3><form method = 'post'><input name = 'changeAdress' type='text' placeholder = 'Muuda aadressi'><input name = 'changeButton' type='submit' value = 'Muuda'></form> <br>";
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

<div class = "header">
	<div id="proov" class="modal">
		<div class="modal-content">
			<span class="close">&times;</span>
			<p><?php 
			require "../../config.php";
			$database = "if17_lahtsten";
			$trailer = $_SESSION['trailer'];
			$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
			$query = "SELECT onehour, twelvehours, oneday, oneweek, onemonth FROM trailerprices INNER JOIN trailerinfo ON trailerprices.trailerId = trailerinfo.trailerId WHERE trailerinfo.trailername = 'jfe'";
			$result = $mysqli->query($query);
			$row = $result->fetch_assoc();
			echo "Ühe tunni hind:" . $row['onehour'] . "€<br> 12 tunni hind: " . $row['twelvehours'] . "€<br> Ühe nädala hind:" . $row['oneweek'] . "€<br> Ühe kuu hind: " . $row['onemonth'] . "€<br>"; 
			
		
		
			?>
		
			</p>
		  </div>

	</div>
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
$sessEmail = $_SESSION['email'];
$query = " SELECT FirstName, LastName, trailerinfo.trailername, trailerinfo.trailerdesc, trailerinfo.trailerpic, trailerusers.Email FROM trailerusers INNER JOIN trailerinfo ON trailerusers.Email = trailerinfo.Email WHERE trailerinfo.Email <> '$sessEmail'";
$result = $mysqli->query($query);
$result_rows = $result->num_rows;
$loendur = 0;
for($x = 0; $x<$result_rows; $x++){
	$loendur = $loendur +1;
	if(isset($_POST['search'])){
		break;
	}
	if ($result_rows > 0) {
		$row = $result->fetch_assoc();
		$trname = $row['trailername'];
		echo "<div class = 'trailersContainer'><div class = 'addTrailer'><br><br><img src =". $row['trailerpic']. " width = '300' height = '200' id = " . str_replace(' ', '_', $row['trailername']) ."><br>";
		echo "Üleslaadija: ". $row["FirstName"] . " " . $row["LastName"] . "<br>  Haagise nimi: ". $row["trailername"]. "<br> Haagise kirjeldus: ". $row["trailerdesc"]. "";
		echo "<p class = 'pricelist' id = 'test" . $loendur . "' >Täpsem hinnakiri</p>";
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

if(isset($_POST['search'])){
	$boxname = $_POST['otsing'];
	if($_POST['values'] == 'haagis'){
		$query = " SELECT FirstName, LastName, trailerinfo.trailername, trailerinfo.trailerdesc, trailerinfo.trailerpic, trailerusers.Email FROM trailerusers INNER JOIN trailerinfo ON trailerusers.Email = trailerinfo.Email WHERE trailername LIKE '%$boxname%'";
	}
	if($_POST['values'] == 'omanik'){
		$query = "SELECT FirstName, LastName, CONCAT(FirstName, ' ', LastName) AS 'FullName' ,trailerinfo.trailername, trailerinfo.trailerdesc, trailerinfo.trailerpic, trailerusers.Email FROM trailerusers INNER JOIN trailerinfo ON trailerusers.Email = trailerinfo.Email WHERE CONCAT(FirstName, ' ', LastName) LIKE '%$boxname%'"; 
	}
	$result = $mysqli->query($query);
	$result_rows = $result->num_rows;
	$loendur = 0;
	for($x = 0; $x<$result_rows; $x++){
		$loendur = $loendur +1;
		if ($result_rows > 0) {
			$row = $result->fetch_assoc();
			$trname = $row['trailername'];
			echo "<div class = 'trailersContainer'><div class = 'addTrailer'><br><br><img src =". $row['trailerpic']. " width = '300' height = '200' id = " . str_replace(' ', '_', $row['trailername']) ."><br>";
			echo "Üleslaadija: ". $row["FirstName"] . " " . $row["LastName"] . "<br>  Haagise nimi: ". $row["trailername"]. "<br> Haagise kirjeldus: ". $row["trailerdesc"]. "<br>";
			echo "<p class = 'pricelist' id = 'test" . $loendur . "' >Täpsem hinnakiri</p>";
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
}
if(isset($_POST['submit'])){
	session_unset();
	header("Location:frontpage.php");
}
include 'footer.php';
?>
<div id="dom-target" style="display: none;">
    <?php 
        echo htmlspecialchars($loendur); 
    ?>
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

var div = document.getElementById('dom-target');
var myData = div.textContent;
for (i = 1; i<myData; i++){
	
	var btn2 = document.getElementById('test' + i);
	
	var modal2 = document.getElementById('proov');


	var span2 = document.getElementsByClassName("close")[1];
	
	console.log(span2);

	btn2.onclick = function() {
		modal2.style.display = "block";
	}
	span2.onclick = function(){
		modal2.style.display = "none";
	}


	window.onclick = function(event) {
		if (event.target == modal) {
			modal2.style.display = "none";
		}
	}
		
}
</script>
