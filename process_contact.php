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

	$postid = form($_POST["postid"]);
	$subject =form($_POST["subject"]);
	$message = form($_POST["message"]);

	if(empty($postid)) {
		
		header("Location: index.php");
		exit();
	}
	
	if(empty($subject)) {
		header("Location: viewpost.php?postid=$postid&error=1");
		exit();
	}
	
	if(empty($message)) {
		
		header("Location: viewpost.php?postid=$postid&error=2");
		exit();
	}
	
	//all good, so do some work
	
	//do some mysql escape string stuff
	
	//find receiver id
	$receiver = @mysql_fetch_array(@mysql_query("SELECT * FROM posts WHERE postid='$postid'"));
	$receiver_user_id = $receiver["user_id"];
	
	
	$random = rand();
	
	//insert into message box
	$time = time() + (12*60*60);
	$time_in = date('Y-m-d H:i:s', $time);
	
	//message formatting
	$message = str_replace('rn', '<br/>', $message);
	//$message = nl2br($message);
	$message = stripslashes($message);
	
	$sql = "INSERT INTO messages VALUES('".$random."', '".$user_id."', '".$subject."','".$message."','".$receiver_user_id."', '".$postid."',0,'".$time_in."')";
	mysql_query($sql) or die(mysql_error());
	
	//notify receiver, if he chooses
	$receiver_notification = $receiver["notification"];
	$receiver_email = $receiver["email"];
	
	if($receiver_notification == 1) {	//he allows
		send_mail($receiver_email, 3);
	}
	
	//redirect user
	header("Location: inbox.php?success=1");
	exit();
?>
	
	