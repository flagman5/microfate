<?php
include("header.php"); // Includes the db and form info.
if (isset($_COOKIE['mfcookie'])) { // User is already logged in.
	header("Location: index.php"); // Goes to main page.
	exit(); // Stops the rest of the script.
} 
?>
  <script>
  $(document).ready(function(){
    $("#regForm").validate({
  rules: {
    password: "required",
    password_again: {
      equalTo: "#password"
    }
  }
});

  });
  </script>
<div id="mainbar">Register</div>
<div id="mainlogin">
<center>
<img src="images/gnome-mime-application-x-svg.png" border="0" style="margin-top:5px; margin-bottom:-10px;">
<?
if (!isset($_POST['submit'])) { // If the form has not been submitted.
	echo "<form action=\"register.php\" method=\"POST\" id=\"regForm\">";
	
	echo "<p>
		  <label for=\"name\">帳號 (請用英文字母或數字)</label><br/>
          <input id=\"name\" name=\"username\" size=\"25\" class=\"required\" minlength=\"2\" />
          </p>";
	echo "<p>
		  <label for=\"password\">密碼</label><br/>
          <input id=\"password\" name=\"password\" size=\"25\" class=\"required\" minlength=\"2\" type=\"password\"/>
          </p>";
	echo "<p>
		  <label for=\"password_again\">再輸入一次密碼</label><br/>
          <input id=\"password_again\" name=\"password_again\" size=\"25\" class=\"required\" minlength=\"2\" type=\"password\"/>
          </p>";
	echo "<p>
		  <label for=\"email\">電子郵址</label><br/>
          <input id=\"email\" name=\"email\" size=\"25\" class=\"required email\" />
		  </p>";
	
	echo "<p><a href=\"http://www.protectwebform.com/\" title=\"Captcha service - protectwebform.com!\">
		  <img src=\"http://www.protectwebform.com/images/ssl_lock.gif\" border=\"0\"></a> 
		  請輸入圖中的文字:<br />
		  <img src=\"http://protectwebform.com/image/26914/\">
		  <input type=\"text\" style=\"vertical-align:top;\" name=\"protectwebformcode\" value=\"\"> 
		  </p>";
	echo "我已經同意本網站使用條款合隱私權政策<br/>";	  
	echo "<input type=\"submit\" name=\"submit\" value=\"送出\">";
	
	echo "</form>";
} 
else { // The form has been submitted.

	////////////////////////////////////////////////////////////
	// Code provided by http://www.protectwebform.com 

	if($GLOBALS['REQUEST_METHOD'] == 'POST' || count($_POST) > 0) { 
	$pwf_message = "您輸入的圖中的文字有問題 請再試一次.";

	if(strlen($_POST['protectwebformcode']) > 30) {
			die($pwf_message);
	}

	$protectwebformresult = 
		@file_get_contents( "http://protectwebform.com/verify01?vui=26914&vp=14dtk260syz5&ri=" . 
		urlencode($_SERVER['REMOTE_ADDR']) . "&vs=" . 
		urlencode($_POST['protectwebformcode'])); 
	if(preg_match("|<authorization status=\"0\"|", $protectwebformresult)) { 
		echo "Warning. You are not authorithed to use image protection provided by 
			http://www.protectwebform.com. Read http://www.protectwebform.com 
			FAQ for more information"; 
	} elseif(!preg_match("|<verification result=\"yes\"/>|", $protectwebformresult)) { 
		die($pwf_message); 
	}
	}                                                                            
	// End of code provided by http://www.protectwebform.com 
	////////////////////////////////////////////////////////////
	
	$username = form($_POST['username']);
	$password_formed = form($_POST['password']);
	
	$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $key = md5("mfkey");
	$password = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $password_formed, MCRYPT_MODE_ECB, $iv);
   
	$email = form($_POST['email']);
	if (($username == "") || ($password == "") || ($email == "")) { // Checks for blanks.
		exit("There was a field missing, please correct the form.");
	}
	$q = mysql_query("SELECT * FROM `users` WHERE username = '$username' OR email = '$email'") or die (mysql_error()); // mySQL Query
	$r = mysql_num_rows($q); // Checks to see if anything is in the db.
	if ($r > 0) { // If there are users with the same username/email.
		exit("帳號 或 電子郵址 已註冊了");
	} else {
		mysql_query("INSERT INTO `users` (username,password,email) VALUES ('$username','$password','$email')") or die (mysql_error()); // Inserts the user.
		send_mail($email, 1);
		echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=login.php?reg=1\">"; // Back to login.
	}
}
mysql_close($db_connect); // Closes the connection.
?>
</center>
</div>

<?
include("ads.php"); 
include("footer.php"); 
?>


