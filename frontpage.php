<?php 
require "../../config.php";
$database ="if17_lahtsten";
if(isset($_POST["loginButton"])){
	$loginEmail = $_POST["loginEmail"];
	$loginPassword = $_POST["loginPassword"];
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		//valmistame ette käsu andmebaasiserverile
		$hash = hash("sha512", $loginPassword);
		$stmt = "SELECT * FROM trailerusers WHERE Email = '$loginEmail' AND Hashpasswd = '$hash'";
		$result = $mysqli->query($stmt);
		while ($row = $result->fetch_assoc()) {
			//echo $row['FirstName']."<br>";
			$name = $row['FirstName'];
		}
		session_start();
		$_SESSION['username']= $name;
		
		if($result->num_rows > 0){
			header("Location: avaleht.php");
			exit();
		}
}



?>

<html lang="et">
<head>
<meta charset="utf-8">
<style>
.header{
	display: block;
	text-align:center;
	background:yellow;
}
.mainpage{
	text-align:center;
}
</style>
	
	<title>Sisselogimine või uue kasutaja loomine</title>
	<header>
	
	
	
</head>
<body>
<div class= "header">
	<h1>Tel nr: 5387250</h1>
	<h2>Email: haagiserent@haagis.ee</h1>
</div>
<div class = "mainpage">
	<h1>Olete jõudnud haagiserendi lehele</h1>
	<h1> Vaata saadaval olevaid <a href= "haagised.php">haagiseid</a> <h1> või <a href= "register.php">loo kasutaja</a></h1>
	<h2>Logi sisse!</h2>
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<label>Kasutajanimi (E-post): </label>
		<input name="loginEmail" placeholder= "Email" type="email">
		<br><br>
		<label>Parool:</label>
		<input name="loginPassword" placeholder="Salasõna" type="password"><span></span>
		<br><br>
		<input name="loginButton" type="submit" value="Logi sisse">
	</form>
	</div>
	
	
	
	
		
</body>
</html>
