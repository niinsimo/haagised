<?php
require "../../config.php";
$database ="if17_lahtsten";
$hash = "";
$notice = "";
$firstnameError = "";
$lastnameError = "";
$emailError = "";
$passwdError = "";
$passwdagainError = "";
$adressError = "";
if(isset($_POST["registerButton"])){
	$signupFirstName = $_POST["signupFirstName"];
	$signupFamilyName = $_POST["signupFamilyName"];
	$signupEmail = $_POST["signupEmail"];
	$passwd = $_POST["passwd"];
	$passwdagain = $_POST["passwdagain"];
	$signUpAdress = $_POST["adress"];
	if(empty ($signupFirstName)){
		$firstnameError = "Eesnimi on kohustuslik";
		
	}
	if(empty($signupFamilyName)){
		$lastnameError = "Perenimi on kohustuslik";
		
	}
	if(empty($signupEmail)){
		$emailError = "Email on kohustuslik";
	}
	
	if(empty($passwd)){
		$passwdError = "Parool on kohustuslik";
	}
	
	
	if(empty($passwdagain)){
		$passwdagainError = "Paroolikinnitus on kohustuslik";
	}
		
	if($passwd != $passwdagain){
		$notice = "Sinu paroolid ei kattu!";
	}
	if(empty($signUpAdress)){
		$adressError = "Aadress on kohustuslik!";
	}
	
	if(empty($notice) and empty ($firstnameError) and empty ($lastnameError) and empty($emailError) and empty($passwdError) and empty ($passwdagainError) and empty ($adressError)){
		$hash=hash("sha512", $passwd);
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//valmistame ette käsu andmebaasiserverile
		$stmt = $mysqli->prepare("INSERT INTO trailerusers (FirstName, LastName, Email, Hashpasswd, Adress) VALUES (?, ?, ?, ?, ?)");
		echo $mysqli->error;
		$stmt->bind_param("sssss", $signupFirstName, $signupFamilyName, $signupEmail, $hash, $signUpAdress);
		if ($stmt->execute()){
			echo "\n Õnnestus!";
			header("Location: frontpage.php");
			exit();
		} else {
			echo "\n Tekkis viga : " .$stmt->error;
		}
		$stmt->close();
		$mysqli->close();
	}
	
}

	





?>
<html lang="et">
<head>
<meta charset="utf-8">
<style>
<?php include 'css/main.css'; ?>
</style>
<form method="POST">
</head>
<body>

		<label>Eesnimi </label>
		<input name="signupFirstName" type="text"><?php echo $firstnameError; ?> 
		<span></span>
		<br>
		<label>Perekonnanimi </label>
		<input name="signupFamilyName" type="text"><?php echo $lastnameError; ?> 
		<span></span>
		<br>
		<label>Email </label>
		<input name="signupEmail" type="text"><?php echo $emailError; ?> 
		<br>
		<label>Parool </label>
		<input name="passwd" type="password"><?php echo $passwdError; ?> 
		<br>
		<label>Parool uuesti </label>
		<input name="passwdagain" type="password"> 
		<br>
		<label>Aadress</label>
		<input name = "adress" type ="text"><?php echo $adressError; ?>
		<br>
		<input name="registerButton" type ="submit" value="Loo kasutaja">
		
		
</form>
</body>
</html>