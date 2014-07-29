<?
include("conf.inc.php");

if (isset($_POST['submit'])) { 
	
	$email = form($_POST["email"]);
	
	$user_info = mysql_query("SELECT * FROM users WHERE email='$email'") or die(mysql_error());
	
	$found = mysql_num_rows($user_info);
	
	if($found == 1) {
		send_mail($email, 2);
	
		header("Location: login.php?success=1");
		exit();
	}
	else {
		header("Location: login.php?error=2");
		exit();
	}
}
?>

<script>
  $(document).ready(function(){
    $("#forgot_info").validate() });
</script>

<div id="change_info">

<form method="POST" id="forgot_info" action="forgot.php">
<p>
	<label for="email">請輸入您註冊的電子郵址:</label><br/>
    <input id="email" name="email" size="25" class="required email"/>
<br/><br/>
<input type="submit" name="submit" value="送出">
</form>
</p>
</div>
	
