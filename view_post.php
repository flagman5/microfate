<?php

	if (isset($_COOKIE['mfcookie'])) { // User logged in.
		//get cookie info
		$user_id = $_COOKIE["mfcookie"];
		$logged_in = 1;
	} 
	

//get variable
$postid = $_GET["postid"];
if(empty($postid)) {
	header("Location: index.php");
	exit();
}

//get error messages
$error = $_GET["error"];
if($error == 1) {
	$error_message = "主旨不可空";
}
else if($error == 2) {
	$error_message = "信內容不可空";
}

include("header.php"); // Includes the db and form info.

?>
  <script>
  $(document).ready(function(){
    $("#replyForm").validate();

  });
  </script>
<div id="mainbar">尋人文章</div>
<div id="mainlogin">

 <?if(!empty($error_message)) {
?>  <center>
	<div id="error_msg">
	<img src="images/unchecked.gif"><br/>
	<?echo $error_message?>
	</div>
	<center>
<?}?>
  
<?	


	$post_result = @mysql_fetch_array(@mysql_query("SELECT * FROM posts WHERE postid='$postid'"));
	
	$subject = $post_result["subject"];
	$city = $post_result["city"];
	
	// create a city look up table
	include("city_lookup.php");
	$city_name = city_lookup($city);
	
	
	$location = $post_result["location"];
	$message = $post_result["message"];
	$date = $post_result["date"];
	
	$searcher = $post_result["searcher"];
	$target = $post_result["target"];
	
	$views = $post_result["views"];
	$views++;
	
	$image_link = $post_result["link"];
	
	//update views
	$sql = mysql_query("UPDATE posts SET views='$views' WHERE postid='$postid'");
?>
<? if($searcher == 1) {
		  echo "<img src=\"images/man02.png\" height=\"20px\" border=\"0\" style=\"margin-top:2px\">";
	   }
	   else {
		  echo "<img src=\"images/woman02.png\" height=\"20px\" border=\"0\" style=\"margin-top:2px\">";
	   }
	   echo "尋";
	   if($target == 1) {
		  echo "<img src=\"images/man02.png\" height=\"20px\" border=\"0\" style=\"margin-top:2px\">";
	   }
	   else {
		  echo "<img src=\"images/woman02.png\" height=\"20px\" border=\"0\" style=\"margin-top:2px\">";
	   }
	?>
	<div id="post_msg">
	
	<h1 style="color: #000;"><?echo $subject?></h1>
	<br/><br/>
	<h2><?echo $city_name?></h2>
	
	地點: <?echo $location?>
	<br/>
	刊登日期: <?echo $date?><br/>
	<p>
	<? echo $message ?>
	</p>
	
	<? if(!empty($image_link)) {
	?>
	<p>
	<img src="<?echo $image_link?>">
	</p>
	<?}?>
	</div>
	<hr>
	<div id="reply_form_main">
	與這個人連絡:<br/><br/>
<?	if ( $logged_in != 1)
	{	
		echo "您必須要先註冊才可以與這個人連絡";
	}
	else {	//display contact box
	
?>
	<form method="POST" action="process_contact.php" id="replyForm">
	
	<label for="subject">主旨</label><br/>
    <input type="text" name="subject" size="50" class="required" minlength="2"><br/>
	<label for="Message">想說的話</label><br/>
   	<TEXTAREA NAME="message" COLS=50 ROWS=6 class="required"></TEXTAREA> <br/>
	<br/><br/>
	
	<input type="submit" name="send" value="送出">
	<input type="hidden" name="postid" value="<?echo $postid?>">
	</form>
<?}?>	
	</div>
	
	</div>
	
<?mysql_close($db_connect); // Closes the connection.?>
	
<?
include("ads.php"); 
include("footer.php"); 
?>
