
<script>
  function loadFile(event) {
	var output = document.getElementById('output');
	output.src = URL.createObjectURL(event.target.files[0]);
	/*
	var basic = document.getElementById('demo-basic').croppie ( {
			viewport: {
				width: 150,
				height: 150
			}
		});
		basic.croppie('bind', {
			url: output.src,
		  });
	});*/
}
</script>
<?php
$target_dir = "profilepics/";
$uploadOk = 1;
$nameError = "";
$commentError = "";
session_start();
if(!isset($_SESSION['username'])){
	header('Location: frontpage.php');
}
require "../../config.php";
if(isset($_POST["submit"])){
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		} else {
			echo "Sorts, midagi läks valesti";
		}
	$database = "if17_lahtsten";
	$trailerName = $_POST['trailerName'];
	$trailerDesc = $_POST['comment'];
	$onehour = $_POST['onehour'];
	$twelvehours = $_POST['twelvehours'];
	$oneday = $_POST['oneday'];
	$oneweek = $_POST['oneweek'];
	$onemonth = $_POST['onemonth'];
	
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$query = $mysqli->prepare ("INSERT INTO trailerinfo(trailername, trailerpic, trailerdesc, Email) VALUES (?,?,?,?)");
	echo $mysqli->error;
	$query->bind_param("ssss", $trailerName, $target_file, $trailerDesc, $_SESSION['email']);
	if($query->execute()){
	
	}
	else{
		echo "Tekkis viga!" . $query->error;
	}
	
		$email = $_SESSION['email'];
		$query = "SELECT trailerId FROM trailerinfo WHERE Email = '$email' ORDER BY trailerId DESC LIMIT 1";
		$result = $mysqli->query($query);
		$row = $result->fetch_assoc();
		$result_trailerId = $row['trailerId'];
		echo $result_trailerId;

		$query = $mysqli->prepare ("INSERT INTO trailerprices(onehour, twelvehours, oneday, oneweek, onemonth, trailerId) VALUES (?,?,?,?,?,?)");
			echo $mysqli->error;
			$query->bind_param("iiiiii", $onehour, $twelvehours, $oneday, $oneweek, $onemonth, $result_trailerId);
			if($query->execute()){
				echo "jee";
				header('Location: upload.php');
			}else{
				echo "Tekkis viga!" . $query->error;
			}
		
	
}
if(isset($_POST["logout"])){
	session_unset();
	header("Location: frontpage.php");
}
$database = "if17_lahtsten";
$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
$email = $_SESSION['email'];
$query = "SELECT * FROM trailerinfo WHERE Email =  '$email'";
$result = $mysqli->query($query);
$result_rows = $result->num_rows;

$query2 = "SELECT  AVG(rating) FROM trailerrating WHERE email = '$email'";
$result2 = $mysqli->query($query2);
$row = $result2->fetch_assoc();
$result_rows2 = $result2->num_rows;
$vastus = $row['AVG(rating)'];
if (is_null($vastus)) {
	$vastus = "-";
}else{
	$vastus = $row['AVG(rating)'];
}

?>

<html lang="et">
<head>
<link href="https://fonts.googleapis.com/css?family=Lato:300,400,400italic,700,700italic" rel="stylesheet">
<link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
<meta charset="utf-8">
<style>
<?php include 'css/main.css'; ?>
</style>
</head>
<body style="text-align: center;">
<?php include("header.php"); ?>

	<div class = "header">
		<div>
			<?php
			$folder = str_replace(' ', '_', $_SESSION['username']) . "_" . $_SESSION['id'] . "/";
			
			if(file_exists("$folder")){
				$file = scandir($folder);
				$_SESSION['file'] = $folder . $file[2];
				if(isset($_POST['submitbtn'])){
					$files = glob("./" . $folder ."/*");
					foreach($files as $file){
						if(is_file($file)){
							unlink($file);
						}
					}
					$target_file = $folder . basename($_FILES["fileToUpload2"]["name"]);
					$_SESSION['file'] = $target_file;
					$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
					$check = getimagesize($_FILES["fileToUpload2"]["tmp_name"]);
					if($check !== false) {
						$uploadOk = 1;
					} else {
						echo "File is not an image.";
						$uploadOk = 0;
					}

					if (move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_file)) {
						} else {
							echo "Sorts, midagi läks valesti";
						}
					
				}
			}
			if(!file_exists("$folder")){
				if(isset($_POST['submitbtn'])){
					mkdir($folder, 0777);
					$target_file = $folder . basename($_FILES["fileToUpload2"]["name"]);
					$_SESSION['file'] = $target_file;
					$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
					$check = getimagesize($_FILES["fileToUpload2"]["tmp_name"]);
					if($check !== false) {
						$uploadOk = 1;
					} else {
						echo "File is not an image.";
						$uploadOk = 0;
					}

					if (move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_file)) {
						} else {
							echo "Sorts, midagi läks valesti";
						}
					
				}
			}
			
			if(file_exists("$folder")){
				chmod($folder, 0777);
				echo "<img class='profile-pic resize' src =" . $_SESSION['file'] . "><br>";
			}
			
			?>
			<h1 class="username"><?php echo $_SESSION['username'];?></h1>
			<div class= "container">
				<ul>
					<li><p>Minu Haagised: </p><a><?php echo $result_rows;?></a></li>
					<li><p>Minu keskmine hinne: </p><a><?php echo $vastus;?></a></li>
					<li><p>Renditud haagiseid: </p><a><?php echo $result_rows;?></a></li>
				</ul>
			</div>
		</div>
		<div class="addTrailerContainer">
			<div class="addTrailer">
				<h2>Lisa enda haagis</h2>
				<form method="post" enctype="multipart/form-data">
					<input type = "text" placeholder = "Haagise nimi" name = "trailerName">
					<br>
					<textarea name= "comment" rows = "5" cols = "40" placeholder = "Tehnilised spetsifikatsioonid" ></textarea>
					<br>
					<div class="prices" >
						<h3>Hinnakiri: </h3>
						<input style="width: 100px;" type = "text" placeholder = "1h" name = "onehour">
						<input style="width: 100px;" type = "text" placeholder = "12h" name = "twelvehours">
						<input style="width: 100px;" type = "text" placeholder = "1 päev" name = "oneday">
						<input style="width: 100px;" type = "text" placeholder = "1 nädal" name = "oneweek">
						<input style="width: 100px;" type = "text" placeholder = "1 kuu" name = "onemonth">
					</div><br>
					
					<div class="upload-btn-wrapper">
						<button  class="btn">Vali pilt</button>
						<input type="file" name="fileToUpload" id="fileToUpload" onchange="loadFile(event)" />			
						<img id="output" />
						<div id="page">
							<div id="demo-basic">
							</div>
						</div>
					</div><br>
					<input type="submit" value="Lae haagis üles" name="submit">
				</form>
			</div>
			<div class="addTrailer">
				<form method = "post" enctype="multipart/form-data">
					<div class="btn">
					<br>
						<button class="btn">Vali pilt</button>
						<input type="file" name="fileToUpload2" id="fileToUpload2"><br>
					</div><br>
					<input type="submit" value="Uuenda profiilipilti" name="submitbtn"><br>
				</form>
				<form method="post" enctype="multipart/form-data">
					<input name = "logout" type = "submit" value = "Logi välja">
				</form>
			</div>
		</div>
		<?php include("footer.php"); ?>
	</div>
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

