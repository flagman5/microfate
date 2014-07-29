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
$postid = form($_GET["postid"]);
if(empty($postid)) {
	header("Location: index.php");
	exit();
}

//get the post original info
$post_info = mysql_fetch_array(mysql_query("SELECT * FROM `posts` WHERE `postid`='$postid'"));

?>
  <script>
  $(document).ready(function(){
    $("#postForm").validate();
	$.get("token.php",function(txt){
	$(".secure").append('<input type="hidden" name="ts" value="'+txt+'" />');
	});

  });
  </script>
  
  <form method="POST" id="postForm" action="process_post.php" class="secure">
   <br/>
   <select name="searcher">
   <option value="1" <?if($post_info["searcher"] == 1) {echo "selected";}?>>男</option>
   <option value="2" <?if($post_info["searcher"] == 2) {echo "selected";}?>>女</option>
   </select>
   尋
   <select name="target">
   <option value="1" <?if($post_info["target"] == 1) {echo "selected";}?>>男</option>
   <option value="2" <?if($post_info["target"] == 2) {echo "selected";}?>>女</option>
   </select>
   <br/><br/>
   <label for="subject">主旨</label><br/>
   <input type="text" name="subject" size="50" class="required" minlength="2" value="<?echo $post_info["subject"]?>"><br/>
   
   <label for="city">城市</label><br/>
   <select name="city">
   <option value="1" <?if($post_info["city"] == 1) {echo "selected";}?>) {>台北市</option>
	<option value="2" <?if($post_info["city"] == 2) {echo "selected";}?>>台北縣</option>
	<option value="3" <?if($post_info["city"] == 3) {echo "selected";}?>>桃園縣</option>
	<option value="4" <?if($post_info["city"] == 4) {echo "selected";}?>>新竹縣市</option>
	<option value="5" <?if($post_info["city"] == 5) {echo "selected";}?>>宜蘭縣</option>
	<option value="6" <?if($post_info["city"] == 6) {echo "selected";}?>>基隆市</option>
	<option value="7" <?if($post_info["city"] == 7) {echo "selected";}?>>台中縣市</option>
	<option value="8" <?if($post_info["city"] == 8) {echo "selected";}?>>彰化縣</option>
	<option value="9" <?if($post_info["city"] == 9) {echo "selected";}?>>雲林縣</option>
	<option value="10" <?if($post_info["city"] == 10) {echo "selected";}?>>苗栗縣</option>
	<option value="11" <?if($post_info["city"] == 11) {echo "selected";}?>>南投縣</option>
	<option value="12" <?if($post_info["city"] == 12) {echo "selected";}?>>台南縣市</option>
	<option value="13" <?if($post_info["city"] == 13) {echo "selected";}?>>高雄縣市</option>
	<option value="14" <?if($post_info["city"] == 14) {echo "selected";}?>>嘉義縣市</option>
	<option value="15" <?if($post_info["city"] == 15) {echo "selected";}?>>屏東縣</option>
	<option value="16" <?if($post_info["city"] == 16) {echo "selected";}?>>台東縣</option>
	<option value="17" <?if($post_info["city"] == 17) {echo "selected";}?>>花蓮縣</option>
	<option value="18" <?if($post_info["city"] == 18) {echo "selected";}?>>外島地區</option>
   </select><br/><br/>
   
   <label for="Location">地點</label><br/>
   <input type="text" name="location" size="30" class="required" minlength="2" value="<?echo $post_info["location"]?>"><br/>
   
  <label for="Message">想說的話</label><br/>
   	<TEXTAREA NAME="message" COLS=50 ROWS=6 class="required"><?echo str_replace('<br/>', ' ', $post_info["message"])?></TEXTAREA> <br/>
  <br/><br/>
  
   <!--<label for="link">假使你有無名照片的連結，請放在這(請不要貼上整本相簿的網址，請貼照片的連結即可)</label><br/>
   <input type="text" name="link" size="50" value="<?echo $post_info["link"]?>><br/>-->
  
  <input type="submit" name="send" value="送出">
    <input type="hidden" name="edit" value="1">
	<input type="hidden" name="postid" value="<?echo $postid?>">
  </form>
  <?mysql_close($db_connect); // Closes the connection.?>
  