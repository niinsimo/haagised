<?php
if(isset($_POST['send'])){
	$msg = "First line of text\nSecond line of text";

	$msg = wordwrap($msg,70);

	mail("stenmarkus12@gmail.com","My subject",$msg);
	echo "Saadetud!";
}



?>

<form method= "POST">
	<input type = "submit" name = "send" value = "Saada meil!">
</form>


