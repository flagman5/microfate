<?php


$ip = $_SERVER['REMOTE_ADDR'];
$ct = mktime();
$verify = md5('mf8'.$ct);

?>
	<br/>
	<h2>謝謝您跟我們連絡</h2>
	<br/>
	<form method="POST" action="contact_website.php">
	<p>
	主旨: <br/>
	<input type="text" name="subject" size="20" value=""><br/>
	信內容: <br/>
	<TEXTAREA NAME="message" COLS=40 ROWS=6></TEXTAREA>
	<br/><br/>
	<input type="submit" name="send" value="送出">
	<input type="hidden" name="ip" value="<?echo $ip?>">
	<input type="hidden" name="time" value="<?echo $ct?>">
	<input type="hidden" name="token" value="<?echo $verify?>">
	</p>
	</form>
	
	
	
