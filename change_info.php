<?php

if (!isset($_COOKIE['mfcookie'])) { // User is not logged in.
	header("Location: index.php"); // Goes to main page.
	exit(); // Stops the rest of the script.
} 

//get cookie info
$user_id = $_COOKIE["mfcookie"];

$type = $_GET["type"];
if(empty($type)) {
	header("Location: index.php"); // Goes to main page.
	exit(); // Stops the rest of the script.
} 


if($type == 1) {
?>


<script>
  $(document).ready(function(){
    $("#change_email").validate() });
</script>

<div id="change_info">

<form method="POST" action="process_info.php" id="change_email">
<p>
	<label for="email">請輸入新的電子郵址:</label><br/>
    <input id="email" name="email" size="25" class="required email"/>
<br/><br/>
<input type="submit" name="submit" value="送出">
<input type="hidden" name="type" value="1">
</form>
</p>
</div>
<?}
else if($type == 2) {
?>
<script>
  $(document).ready(function(){
    $("#change_password").validate({
  rules: {
    password: "required",
    password_again: {
      equalTo: "#password"
    }
  }
});

  });
  </script>

<div id="change_info">

<form method="POST" action="process_info.php" id="change_password">
<p>
	<label for="password">請輸入新的密碼:</label><br/>
    <input id="password" name="password" size="25" class="required" minlength="2" type="password"/>
<br/><br/>
	<label for="password_again">請再輸入一次新的密碼:</label><br/>
    <input id="password_again" name="password_again" size="25" class="required" minlength="2" type="password"/>
<br/><br/>
<input type="submit" name="submit" value="送出">
<input type="hidden" name="type" value="2">
</form>
</p>
</div>
<?}
else if($type == 3) {
?>
<div id="change_info">

<form method="POST" action="process_info.php" id="change_notification">
<p>
	<label for="notification">您要本網站寄信給您嗎?</label><br/>
    <input type="radio" name="notification" value="1" checked>要 <br>
	<input type="radio" name="notification" value="2">不要<br>
<br/><br/>
<input type="submit" name="submit" value="送出">
<input type="hidden" name="type" value="3">
</p>
</form>
</div>
<?}?>