<?php

setcookie("mfcookie", $user_id, time()-3600, "/", ".microfate.com"); 
setcookie("mflogin", $user_id, time()-3600, "/", ".microfate.com"); 
header("Location: index.php"); // Goes back to login.
?>
