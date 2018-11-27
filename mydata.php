<?php
require "../../../config.php";
$database = "if17_lahtsten";
session_start();
$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
$query = "SELECT FirstName, LastName, Adress FROM trailerusers WHERE Email = '" . $_SESSION['email'] . "' ";
$result = $mysqli->query($query);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "Eesnimi: ". $row["FirstName"]. "<input name = 'changeName' type='text' placeholder = 'Muuda nime'>"; 
		echo "<input name = 'changeButton' type='button' value = 'Muuda'>  <br>"; 
		echo "Perenimi: ". $row["LastName"]. "<input name = 'changeFam' type='text' placeholder = 'Muuda perenime'>";
		echo "<input name = 'changeButton2' type='button' value = 'Muuda'> <br> Aadress: " . $row["Adress"] . "<input name = 'changeAdress' type='text' placeholder = 'Muuda aadressi'><input name = 'changeButton3' type='button' value = 'Muuda'> <br>";
    }
} else {
    echo "Midagi läks valesti!";
}
if(isset($_POST['changeButton'])){
	$firstName = $_POST['changeName'];
	$query = "UPDATE trailerusers SET FirstName ='$firstName'";
	$result = $mysqli->query($query);
}
 
?>