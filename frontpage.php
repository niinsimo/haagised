<?php 
require "../../config.php";
$database ="if17_lahtsten";
$error = "";
if(isset($_POST["loginButton"])){
	$loginEmail = $_POST["loginEmail"];
	$loginPassword = $_POST["loginPassword"];
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
		$hash = hash("sha512", $loginPassword);
		$stmt = "SELECT * FROM trailerusers WHERE Email = '$loginEmail' AND Hashpasswd = '$hash'";
		$result = $mysqli->query($stmt);
		while ($row = $result->fetch_assoc()) {
			$name = $row['FirstName'];
			$email = $row['Email'];
			$id = $row['id'];
			$lastname = $row['LastName'];
		}
		
		
		if($result->num_rows > 0){
			session_start();
			$_SESSION['username']= $name;
			$_SESSION['email'] = $email;
			$_SESSION['id'] = $id;
			$_SESSION['lastname'] = $lastname;
			header("Location: avaleht.php");
			exit();
		}
		else{
			$error = "Su kasutajanimi või parool on vale!";
		}
}



?>

<html lang="et">
<head>
<meta charset="utf-8">
<style>
<style>
<?php include 'css/main.css'; ?>
</style>	
	<title>H-rent - elu nagu kiirteel!</title>	
</head>

<body>
<div class= "frontPageContainer">
	<img class="mainlogo" src="css/pics/haagiserent-suur.png">
	
	<form class="login" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
		<input type="text" name="loginEmail" placeholder= "Email" type="email"><br>
		<input name="loginPassword" placeholder="Salasõna" type="password"><span></span><br>
		<input class="submitButton" name="loginButton" type="submit" value="Logi sisse">
		<p class = "error"><?php echo $error ?>
	</form>
	
	<img src="css/pics/haagiseskeem.png">
</div>
		
</body>
</html>
