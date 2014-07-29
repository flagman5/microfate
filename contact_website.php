<?
	
	$ip = $_POST['ip'];
	$time = $_POST['time'];
	$token = $_POST['token'];
	
	if(md5('mf8'.$time) != $token) {
	
		exit();
	}
	
	$subject =  'MICROFATE'.$_POST['subject'];
	$message =  $_POST['message'];
	
	mail('flagman5@gmail.com', $subject, $message);
	
	header("Location:faq.php?success=1");
	exit();
?>