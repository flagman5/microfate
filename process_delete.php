<?

	if (!isset($_COOKIE['mfcookie'])) { // User is not logged in.
		header("Location: index.php"); // Goes to main page.
		exit(); // Stops the rest of the script.
		} 

		//get cookie info
		$user_id = $_COOKIE["mfcookie"];

		include("conf.inc.php"); // Includes the db and form info.

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

		//get variable
		$postid = form($_POST["postid"]);
		if(empty($postid)) {
			header("Location: profile.php");
			exit();
		}
				
		
		
		$sql = "DELETE FROM `posts` WHERE `postid`='$postid'";
		mysql_query($sql) or die(mysql_error());
		
		//redirect user
		header("Location: user_view_post.php?success=2");
		exit();
?>