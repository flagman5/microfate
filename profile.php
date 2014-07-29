<?
if (!isset($_COOKIE['mfcookie'])) { // User is not logged in.
	header("Location: index.php"); // Goes to main page.
	exit(); // Stops the rest of the script.
} 

//get cookie info
$user_id = $_COOKIE["mfcookie"];

//get success messages
$success = $_GET["success"];
if($success == 1) {
	$success_message = "您的資料以更新";
}
if($success == 2) {
	$success_message = "您的文章已刊登";
}

include("header.php");

	////////////////////////////////////
	if(isset($_COOKIE["mflogin"])) {	//security check
		$login_user_info = @mysql_fetch_array(@mysql_query("SELECT * FROM `users` WHERE `user_id`='$user_id'"));
		$login_username = $login_user_info["username"];
		
		$ip_parts = explode(".",$_SERVER['REMOTE_ADDR']);
			
		$cookie_ip = $ip_parts[0].".".$ip_parts[1].".".$ip_parts[2];
		
		if(md5($login_username.$cookie_ip) != $_COOKIE["mflogin"]) {
			echo "<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=logout.php\">"; // IP changed, security risk
			exit();
		}
	}
	else {
		//security breach
		exit();
	}
		
	/////////////////////////////////////////	

?>

<div id="mainbar">個人檔案控制台</div>
<div id="main">

<div id="profile">
		<?if(!empty($success_message) && ($success == 2)) {
		?>	<center>
			<div id="sucess_msg">
			<img src="images/checked.gif"><br/>
			<?echo $success_message?>
			</div>
			</center>
		<?}?>
		<div id="box_header">
		<h3>管理文章<img src="images/gthumb.png" border="0" height="40px"></h3> 
		</div>
		<div id="box2">
		
		<ul>
		<li><img src="images/crayon.png" border="0" height="20px" style="margin-bottom:-3px"><a href="create_post.php">刊登文章</a></li>
		<li><img src="images/gnome-fs-directory-visiting.png" border="0" height="20px" style="margin-bottom:-5px"><a href="user_view_post.php">查詢我以前的文章 (修改/刪除)</a></li>
		</ul>
		</div>
		
		<div id="box_header">
		<h3>帳戶 <img src="images/gnome-fs-client.png" border="0" height="40px" style="margin-bottom:-2px;"></h3>
		<?if(!empty($success_message) && ($success != 2)) {
		?>	<center>
			<div id="sucess_msg">
			<img src="images/checked.gif"><br/>
			<?echo $success_message?>
			</div>
			</center>
		<?}?>
		</div>
		<div id="box2">
	<?
		$user_info = mysql_fetch_array(mysql_query("SELECT * FROM users WHERE user_id='$user_id'"));
		$email = $user_info["email"];
		$notification = $user_info["notification"];
		if($notification == 1) {
			$status = "讓本網站寄信給您";
		}
		else {
			$status = "不要本網站寄信給您";
		}
	?>
		
		<ul>
		<li>目前帳戶的電子郵址: <?echo $email?> <a href="change_info.php?type=1&height=200" class="thickbox">改電子郵址</a></li>
		<li><a href="change_info.php?type=2&height=200" class="thickbox">改密碼</a></li>
		<li>現在您 <?echo $status?> <a href="change_info.php?type=3&height=200" class="thickbox">改通知設定</a></li>
		</ul>
		</div>
</div>


</div>

<?include("ads.php")?>
<?include("footer.php");?>



