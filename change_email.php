<?php
/*
if (!isset($_COOKIE['mfcookie'])) { // User is not logged in.
	header("Location: index.php"); // Goes to main page.
	exit(); // Stops the rest of the script.
} 

//get cookie info
$user_id = $_COOKIE["mfcookie"];
)*/
include("conf.inc.php");

$city_name = @mysql_fetch_array(@mysql_query("SELECT * FROM city WHERE city_id='1'"));
echo $city_name["name"];
?>
<script>
  $(document).ready(function(){
    $("#change_email").validate() });
</script>

<div id="change_info">

<form method="POST" action="process_info.php" id="change_email">
<p>
	<label for="email">Please enter your new email address:</label><br/>
    <input id="email" name="email" size="25" class="required email"/>
</p>

<input type="submit" name="submit" value="submit">
<input type="hidden" name="type" value="1">

</div>