<?		
		if (isset($_COOKIE['mfcookie'])) { // User is already logged in.
			header("Location: index.php"); // Goes to main page.
			exit(); // Stops the rest of the script.
		}
		
if (!isset($_POST['submit'])) { // The form has not been submitted.
		
		

		include("header.php"); // Includes the db and form info.
		
		//get error messages
		$error = $_GET["error"];
		if($error == 1) {
			$error_message = "帳號或密碼無效 請再試一次";
		}
		else if($error == 2) {
			$error_message = "帳號或密碼無在系統裡 請再試一次";
		}
		
		//get success messages
		$success = $_GET["success"];
		if($success == 1) {
			$success_message = "帳號和密碼已傳寄了";
		}
		
?>
<div id="mainbar">登入</div>
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

<center>
<img src="images/gnome-terminal.png" border="0" style="margin-top:5px; margin-bottom:-10px;">
<?
		$just_reg = $_GET['reg'];
		if($just_reg == 1) {// just registered
			
			echo "<div id=\"sucess_msg\">";
			echo  "Please log in with you new account!";
			echo "</div>";
		}
		echo "<form action=\"login.php\" method=\"POST\">";
		echo "<p>
			<label for=\"name\">帳號 </label><br/>
			<input id=\"name\" name=\"username\" size=\"25\" class=\"required\" minlength=\"2\" />
			 <br/>";
		echo "
			<label for=\"password\">密碼</label><br/>
			<input id=\"password\" name=\"password\" size=\"25\" class=\"required\" minlength=\"2\" type=\"password\"/>
			<br/><br/>";
			
		echo "<input type=\"checkbox\" name=\"remember\" value=\"1\"><label for=\"remember\"> 記住我的登入資訊</label><br/>
			  
			  </p>";
			  
		echo "<input type=\"submit\" name=\"submit\" value=\"送出\">";
		echo "<p><a href=\"forgot.php?height=200\" class=\"thickbox\">忘記帳號/密碼</a></p>";
		echo "</form>";
	} else {
		include("conf.inc.php"); // Includes the db and form info.

		$username = form($_POST['username']);
		
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$key = md5("mfkey");
		$password = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $_POST['password'], MCRYPT_MODE_ECB, $iv);
		
		$q = mysql_query("SELECT * FROM `users` WHERE username = '$username' AND password = '$password'") or die (mysql_error()); // mySQL query
		$r = mysql_num_rows($q); // Checks to see if anything is in the db.
		if ($r == 1) { // There is something in the db. The username/password match up.
			$_SESSION['logged'] = 1; // Sets the session.
			
			$user_info = mysql_fetch_array($q);
			
			$user_id = $user_info["user_id"];
			
			$ip_parts = explode(".",$_SERVER['REMOTE_ADDR']);
			
			$cookie_ip = $ip_parts[0].".".$ip_parts[1].".".$ip_parts[2];
			
			$cookie = md5 (
							$username .
							$cookie_ip
						 );
			
			if($_POST["remember"] == 1) {
				setcookie("mfcookie", $user_id, time()+60*60*24*30*12, "/", ".microfate.com"); 
				setcookie("mflogin", $cookie, time()+60*60*24*30*12, "/", ".microfate.com");
			}
			else {
				setcookie("mfcookie", $user_id, 0, "/", ".microfate.com"); 
				setcookie("mflogin", $cookie, 0, "/", ".microfate.com");
			}
			
			
			
			echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=profile.php\">"; // Back to page.
			exit(); // Stops the rest of the script.
		} else { // Invalid username/password.
			header("Location: login.php?error=1");
			exit(); // Stops the script with an error message.
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


