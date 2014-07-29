<?
	include("conf.inc.php"); // Includes the db and form info.
	if (!isset($_COOKIE['mfcookie'])) { // User is not logged in.
		header("Location: index.php"); // Goes to main page.
		exit(); // Stops the rest of the script.
	} 
	//get cookie info
	$user_id = $_COOKIE["mfcookie"];
	
	////////////////////////////////////
	if(isset($_COOKIE["mflogin"])) {	//security check
		$login_user_info = @mysql_fetch_array(@mysql_query("SELECT * FROM `users` WHERE `user_id`='$user_id'"));
		$login_username = $login_user_info["username"];
		
		$ip_parts = explode(".",$_SERVER['REMOTE_ADDR']);
			
		$cookie_ip = $ip_parts[0].".".$ip_parts[1].".".$ip_parts[2];
		
		if(md5($login_username.$cookie_ip) != $_COOKIE["mflogin"]) {
			echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=logout.php\">"; // IP changed, security risk
			exit();
		}
	}
	else {
		//security breach
		exit();
	}
		
	/////////////////////////////////////////	
	
	$type = form($_POST["type"]);

	$email = form($_POST["email"]);
	$password =form($_POST["password"]);
	$notification = form($_POST["notification"]);

	if(empty($type)) {
		
		header("Location: index.php");
		exit();
	}
	
	if($type == 1) {	//change email
		
		$sql = "UPDATE `users` SET email='$email' WHERE `user_id`='$user_id'";
		mysql_query($sql) or die(mysql_error());
	}
	
	if($type == 2) {	//change password
		
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$key = md5("mfkey");
		$password = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $password, MCRYPT_MODE_ECB, $iv);
		
		$sql = "UPDATE `users` SET password='$password ' WHERE `user_id`='$user_id'";
		mysql_query($sql) or die(mysql_error());
	}
		
	if($type == 3) {	//change notification
		
		$sql = "UPDATE `users` SET notification='$notification' WHERE `user_id`='$user_id'";
		mysql_query($sql) or die(mysql_error());
	}
		
	//redirect user
	header("Location: profile.php?success=1");
	exit();
?>
	
	