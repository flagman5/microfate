<?php

	if (!isset($_COOKIE['mfcookie'])) { // User is not logged in.
		header("Location: index.php"); // Goes to main page.
		exit(); // Stops the rest of the script.
	} 
	//get cookie info
	$user_id = $_COOKIE["mfcookie"];


//get cookie info
$user_id = $_COOKIE["mfcookie"];

//get error messages
$error = $_GET["error"];
if($error == 1) {
	$error_message = "主旨不可空";
}
else if($error == 2) {
	$error_message = "信內容不可空";
}

//get success
$success = $_GET["success"];
if($success == 1) {
	$success_message = "您的文章已刊登";
}

include("header.php"); // Includes the db and form info.

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

?>
  <script>
  $(document).ready(function(){
    $("#postForm").validate();
	$.get("token.php",function(txt){
	$(".secure").append('<input type="hidden" name="ts" value="'+txt+'" />');
	});
  });
  </script>
<div id="mainbar">刊登文章</div>
<div id="mainlogin">
  
    <?if(!empty($error_message)) {
?>  <center>
	<div id="error_msg">
	<img src="images/unchecked.gif"><br/>
	<?echo $error_message?>
	</div>
	<center>
<?}?>

  <?if(!empty($success_message)) {
?>	<center>
	<div id="sucess_msg">
	<img src="images/checked.gif"><br/>
	<?echo $success_message?>
	</div>
	<center>
<?}?>
  
  <form method="POST" id="postForm" action="process_post.php" class="secure">
   <br/>
   <select name="searcher">
   <option value="1">男</option>
   <option value="2">女</option>
   </select>
   尋
   <select name="target">
   <option value="1">男</option>
   <option value="2">女</option>
   </select>
   <br/><br/>
   <label for="subject">主旨</label><br/>
   <input type="text" name="subject" size="50" class="required" minlength="2"><br/>
   
   <label for="city">城市</label><br/>
   <select name="city">
   <?include("select_city.html");?>
   </select><br/><br/>
   
   <label for="Location">地點</label><br/>
   <input type="text" name="location" size="30" class="required" minlength="2"><br/>
   
  <label for="Message">想說的話</label><br/>
   	<TEXTAREA NAME="message" COLS=50 ROWS=6 class="required"></TEXTAREA> <br/>
  <br/><br/>
  <!--
  <label for="link">假使你有無名照片的連結，請放在這(請不要貼上整本相簿的網址，請貼照片的連結即可)</label><br/>
   <input type="text" name="link" size="50"><br/>
   -->
  <input type="submit" name="send" value="送出">
  </form>
  
  </div>
  
  
	<?mysql_close($db_connect); // Closes the connection.?>
	
<?
include("ads.php"); 
include("footer.php"); 
?>