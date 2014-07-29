<?
	/////////////////////////////////////////////
	$proceed = false;
	$seconds = 60*10;
	
	if(isset($_POST['ts']) && isset($_COOKIE['token']) && $_COOKIE['token'] == md5('mf8'.$_POST['ts'])) $proceed = true;

	if(!$proceed) { 
		echo 'Form processing halted for suspicious activity';
		exit;
	}
	/*
	if(((int)$_POST['ts'] + $seconds) < mktime()) {
		echo 'Too much time elapsed';
		exit;
	}
	*/
	///////////////////////////////////////////////
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
	
	$subject = form($_POST["subject"]);
	$message = trim(form($_POST["message"]));
	$location = form($_POST["location"]);
	$city = form($_POST["city"]);
	$searcher = form($_POST["searcher"]);
	$target = form($_POST["target"]);
	
	$edit = form($_POST["edit"]);
	$postid = form($_POST["postid"]);
	
	$link = $_POST['link'];
	
	//message formatting
	$message = str_replace('rn', '<br/>', $message);
	//$message = nl2br($message);
	$message = stripslashes($message);
	
	if( ($edit == 1) && !empty($postid)) {
	
		$sql = "UPDATE `posts` SET `subject`='$subject',`city`='$city',`location`='$location',`message`='$message',`searcher`='$searcher', `target`='$target' WHERE `postid`='$postid'";
		mysql_query($sql) or die(mysql_error());
		
		//redirect user
		header("Location: user_view_post.php?success=1");
		exit();
	}
	
	if( ($edit == 2) && !empty($postid)) {
	
 		$sql = "DELETE FROM `posts` WHERE `postid`='$postid'";
		mysql_query($sql) or die(mysql_error());
		
		//redirect user
		header("Location: user_view_post.php?success=2");
		exit();
	}
		
	
	if(empty($subject)) {
		header("Location: creat_post.php?error=1");
		exit();
	}
	
	if(empty($message)) {
		
		header("Location: creat_post.php?error=2");
		exit();
	}
	
	if(empty($location)) {
		
		header("Location: creat_post.php?error=3");
		exit();
	}
	//all good, so do some work
	
	
	//time zone	
	$time = time() + (12*60*60);
	$time_in = date('Y-m-d H:i:s', $time);
	
	//link 
	if(empty($link)) {
		$image_link = "";
	}
	else {
		$image_link = wretch_link_parse($link);
	}
	
	
	
	//insert into posts box
	$sql = "INSERT INTO posts VALUES(NULL, '".$user_id."', '".$subject."','".$city."','".$location."','".$message."','".$searcher."','".$target."',0,'".$image_link."', '".$time_in."')";
	mysql_query($sql) or die(mysql_error());
	
	mysql_close($db_connect); // Closes the connection.
	//redirect user
	header("Location: profile.php?success=2");
	exit();
?>
	
	