<?php
require "../../config.php";
$database = "if17_lahtsten";
session_start();
$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
$query = "SELECT FirstName, LastName, Adress FROM trailerusers WHERE Email = '" . $_SESSION['email'] . "' ";
$result = $mysqli->query($query);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Eesnimi: ". $row["FirstName"] . "</br>"; 
		echo "Perenimi: ". $row["LastName"]. "</br>";
		echo "Aadress: " . $row["Adress"] . "<form method = 'post' action = 'mydata.php'><input name = 'changeAdress' type='text' placeholder = 'Muuda aadressi'><input name = 'changeButton' type='submit' value = 'Muuda'></form> <br>";
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