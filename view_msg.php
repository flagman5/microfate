<?php

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
$msgid = form($_GET["msgid"]);
if(empty($msgid)) {
	header("Location: index.php");
	exit();
}

//get error messages
$error = form($_GET["error"]);
if($error == 1) {
	$error_message = "主旨不可空";
}
else if($error == 2) {
	$error_message = "信內容不可空";
}

?>

  <?if(!empty($error_message)) {
?>
	<div id="error_msg">
	<?echo $error_message?>
	</div>
<?}?>
  
<?
	$msg_result = @mysql_fetch_array(@mysql_query("SELECT * FROM messages WHERE msgid='$msgid'"));
	
	$sql = mysql_query("UPDATE `messages` SET `read`='1' WHERE `msgid`='$msgid'"); // mark the message read
	
	$postid = $msg_result["postid"];
	$subject = $msg_result["subject"];
	$message = $msg_result["message"];
	$date = $msg_result["date"];
	$sender = $msg_result["senderid"];
	
	$from_info =  @mysql_fetch_array(@mysql_query("SELECT * FROM users WHERE user_id='$sender'"));
	$from_username = $from_info["username"];
			
?>  <br/>
	<h1><?echo $from_username?> 寄寫:</h1>
	<br/>
	<h2>主旨: <?echo $subject?></h2>
	<br/>
	<h2>日期: <?echo $date?></h2>
	<br/>
	<p><? echo $message ?></p>
	<br/>
	<hr><br/>
	<div id="reply_form">
	回覆:<br/>
	
	<form method="POST" action="process_contact.php">
	
	主旨: <br/>
	<input type="text" name="subject" size="20" value="RE:<?echo $subject?>"><br/>
	信內容: <br/>
	<TEXTAREA NAME="message" COLS=40 ROWS=6></TEXTAREA>
	<br/><br/>
	<input type="submit" name="send" value="送出">
	<input type="hidden" name="postid" value="<?echo $postid?>">
	<input type="hidden" name="token" value="<?echo $token?>">
	</form>
	
	</div>
	
	<?mysql_close($db_connect); // Closes the connection.?>
	
