<?php
	$db_user = "yardsale"; // Username
	$db_pass = "4Q8900XfuI"; // Password
	$db_database = "yardsale_mf"; // Database Name
	$db_host = "localhost"; // Server Hostname
	$db_connect = mysql_connect ($db_host, $db_user, $db_pass); // Connects to the database.
	$db_select = mysql_select_db ($db_database); // Selects the database. 
	
	date_default_timezone_set('Asia/Taipei');

	
	/*mysql_query("SET character_set_results=utf8", $db_connect);
	mysql_query("SET character_set_client=utf8", $db_connect);
	mysql_query("SET character_set_connection=utf8", $db_connect); */
	function form($data) { // Prevents SQL Injection
	   global $db_connect;
	   //$data = ereg_replace("[\'\")(;|`,<>]", "", $data);
	   $data = mysql_real_escape_string(trim($data), $db_connect);
	   return stripslashes($data);
	}
	
	function send_mail($email, $type) {
	
		$user_info = @mysql_fetch_array(@mysql_query("SELECT * FROM users WHERE email='$email'"));
		
		$username = $user_info["username"];
		$password_formed = $user_info["password"];
		
		$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
		$iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
		$key = md5("mfkey");
		$password = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $password_formed, MCRYPT_MODE_ECB, $iv);
		
		if($type == 1) {	//welcome email
			$to = $email;
			$subject = "歡迎您成為微緣的會員";
			$msg = "親愛的".$username."您好，
					
					歡迎您成為微緣的會員！
					
					您註冊的電子郵址是: $email 
					您註冊的密碼是: $password 
					
					謝謝您的參加!
					
					";
			$headers = "From: admin@microfate.com\nReply-To: admin@microfate.com";
			$config = "-fadmin@microfate.com";
			mail("$to", "$subject", "$msg", "$headers", "$config");
			return;
			
		}
		else if($type == 2) {
			$to = $email;
			$subject = "您的微緣會員帳號和密碼";
			$msg = "親愛的".$username."您好，
					
					您註冊的電子郵址是: $email 
					您註冊的密碼是: $password
					
					謝謝您!
					
					";
			$headers = "From: admin@microfate.com\nReply-To: admin@microfate.com";
			$config = "-fadmin@microfate.com";
			mail("$to", "$subject", "$msg", "$headers", "$config");
			return;
			
		}
		else if($type == 3) {	//got a new mail
			$to = $email;
			$subject = "您有新的信件在微緣";
			$msg = "親愛的".$username."您好，
					
					您有新的信件！
					
					請登入您的帳號 wwww.mf8.tw 
					
					您註冊的電子郵址是: $email 
					您註冊的密碼是: $password 
					
					謝謝您的參加!
					
					";
			$headers = "From: admin@microfate.com\nReply-To: admin@microfate.com";
			$config = "-fadmin@microfate.com";
			mail("$to", "$subject", "$msg", "$headers", "$config");
			return;
		}
	}
	
	function wretch_link_parse($link) {
		
		//check validity of link first
		if(strpos($link, 'www.wretch.cc/album/show.php') == false) {
			$image_link = 0;
			
			return $image_link;
			exit();
		}
		
		$string = file_get_contents($link);
		
		$part1 = explode(".jpg", $string);
		
		$part2 = explode("<img id='DisplayImage'", $part1[0]);
		
		//echo $part2[1];
		
		$image_link = substr($part2[1], 6);
		
		$image_link .= ".jpg";
		
		return $image_link;
	}
?>
