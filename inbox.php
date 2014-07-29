<?php


if (!isset($_COOKIE['mfcookie'])) { // User is not logged in.
	header("Location: index.php"); // Goes to main page.
	exit(); // Stops the rest of the script.
} 
include("header.php"); // Includes the db and form info.
//get cookie info
$user_id = $_COOKIE["mfcookie"];

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

//get success messages
$success = $_GET["success"];
if($success == 1) {
	$success_message = "您的信息已傳送出去";
}
?>
<script>
  $(document).ready(function(){
    $("#mailcenter > ul").tabs();
	
	$("#mailin")
		.tablesorterPager({container: $("#pager1")});
	
    $("#mailout")
		.tablesorterPager({container: $("#pager2")});
  });
 
  </script>

<div id="mainbar">信箱</div>
<div id="mainlogin">

  <?if(!empty($success_message)) {
?>	<center>
	<div id="sucess_msg">
	<img src="images/checked.gif"><br/>
	<?echo $success_message?>
	</div>
	</center>
<?}?>
<img src="images/feather.png" border="0">

<div id="mailcenter">
	<ul>
        <li><a href="#tab-1"><span>收件匣</span></a></li>
        <li><a href="#tab-2"><span>寄件備份</span></a></li>
    </ul>

	<div id="tab-1">
		<table id="mailin" class="tablesorter"> 
		<thead> 
		<tr> 
			<th>寄件人</th> 
			<th>主旨</th> 
			<th>日期</th> 
		</tr> 
		</thead> 
		<tbody> 
	<?
	$Limit = 10; //Number of results per page

	$page=$_GET["page1"]; //Get the page number to show
	
	If($page == "") $page=1; //If no page number is set, the default page is 1

	//Get the number of results
	$SearchResult=mysql_query("SELECT * FROM `messages` WHERE `receiveid`='$user_id' ORDER BY date DESC") or die(mysql_error());
	$NumberOfResults=mysql_num_rows($SearchResult);

	//Get the number of pages
	$NumberOfPages1=ceil($NumberOfResults/$Limit);

	//Get only the relevant info for the current page using LIMIT
	$received_msg=mysql_query("SELECT * FROM `messages` WHERE `receiveid`='$user_id' ORDER BY date DESC LIMIT " . ($page-1)*$Limit . ",$Limit") or die(mysql_error());
	
	/*
	$sql = "SELECT * FROM messages WHERE receiveid='$user_id' ORDER by date DESC";
	$received_msg = mysql_query($sql) or die(mysql_error());*/
	
	$num = mysql_num_rows($received_msg);
	
	if($num == 0) {
		echo "<tr>";
		echo "You have no messages";
		echo "</tr>";
	}
	else {
		
		for($i=0;$i<$num;$i++) {
			
			echo "<tr>";
			
			$msgid = mysql_result($received_msg, $i, "msgid");
			
			$from_id = mysql_result($received_msg, $i, "senderid");
			
			$from_info =  @mysql_fetch_array(@mysql_query("SELECT * FROM users WHERE user_id='$from_id'"));
			
			$from_username = $from_info["username"];
			
			echo "<td>";
			echo $from_username;
			echo "</td>";
			
			$subject =  mysql_result($received_msg, $i, "subject");
			
			echo "<td>";
			echo "<a href=\"view_msg.php?msgid=$msgid&type=r\" class=\"thickbox\">$subject</a> ";
			//echo "<a href=\"view_msg.php?msgid=$msgid&type=r\">$subject</a>";
			echo "</td>";
			
			$date =  mysql_result($received_msg, $i, "date");
			
			echo "<td>";
			echo $date;
			echo "</td>";
			
			echo "</tr>";
		}
	}
	
	?>
	</tbody> 
	
	</table> 
	<?
	//Create and print the Navigation bar
		$Nav="";
		
		For($i = 1 ; $i <= $NumberOfPages1 ; $i++) {
			If($i == $page) {
				$Nav .= "<B>$i</B>";
			}
			Else{
				if(empty($city)) {
				
					$Nav .= "<A HREF=\"inbox.php?page1=" . $i . "\">$i</A>";
				}
				else {
					$Nav .= "<A HREF=\"inbox.php?page1=" . $i . "city=$city\">$i</A>";
				}
			}
		}
	Echo "頁" . $Nav; 
?>	
	
	</div>
	
	<div id="tab-2">
	<table id="mailout" class="tablesorter"> 
		<thead> 
		<tr> 
			<th>收件人</th> 
			<th>主旨</th>
			<th>已取讀</th>
			<th>日期</th> 
		</tr> 
		</thead> 
		<tbody> 
	<?
	$Limit = 10; //Number of results per page

	$page=$_GET["page2"]; //Get the page number to show
	
	If($page == "") $page=1; //If no page number is set, the default page is 1

	//Get the number of results
	$SearchResult=mysql_query("SELECT * FROM `messages` WHERE `senderid`='$user_id' ORDER BY date DESC") or die(mysql_error());
	$NumberOfResults=mysql_num_rows($SearchResult);

	//Get the number of pages
	$NumberOfPages2=ceil($NumberOfResults/$Limit);

	//Get only the relevant info for the current page using LIMIT
	$sent_msg=mysql_query("SELECT * FROM `messages` WHERE `senderid`='$user_id' ORDER BY date DESC LIMIT " . ($page-1)*$Limit . ",$Limit") or die(mysql_error());
	/*
	$sql = "SELECT * FROM messages WHERE senderid='$user_id' ORDER by date DESC";
	$sent_msg = mysql_query($sql) or  die(mysql_error());*/
	
	$num = mysql_num_rows($sent_msg);
	
	if($num == 0) {
		
		echo "You have no messages";
	}
	else {
		
		for($i=0;$i<$num;$i++) {
			echo "<tr>";
			
			$msgid = mysql_result($sent_msg, $i, "msgid");
			
			$to_id = mysql_result($sent_msg, $i, "receiveid");
			
			$to_info =  @mysql_fetch_array(@mysql_query("SELECT * FROM users WHERE user_id='$to_id'"));
			
			$to_username = $to_info["username"];
			
			echo "<td>";
			echo $to_username;
			echo "</td>";
			
			$subject =  mysql_result($sent_msg, $i, "subject");
			
			echo "<td>";
			echo "<a href=\"view_msg.php?msgid=$msgid&type=r\" class=\"thickbox\">$subject</a> ";

			//echo "<a href=\"view_msg.php?msgid=$msgid\">$subject</a>";
			echo "</td>";
			
			$read = mysql_result($sent_msg, $i, "read");
			
			echo "<td>";
			if($read == 0) {
				echo "未取讀";
			}
			else {
				echo "已取讀";
			}
			echo "</td>";
			
			$date =  mysql_result($sent_msg, $i, "date");
			echo "<td>";
			echo $date;
			echo "</td>";
			
			echo "</tr>";
		}
	}
	mysql_close($db_connect); // Closes the connection.
	?>
	</tbody> 

	</table> 
	<?
	//Create and print the Navigation bar
		$Nav="";
		
		For($i = 1 ; $i <= $NumberOfPages2 ; $i++) {
			If($i == $page) {
				$Nav .= "<B>$i</B>";
			}
			Else{
				if(empty($city)) {
				
					$Nav .= "<A HREF=\"inbox.php?page2=" . $i . "\">$i</A>";
				}
				else {
					$Nav .= "<A HREF=\"inbox.php?page2=" . $i . "city=$city\">$i</A>";
				}
			}
		}
	Echo "頁" . $Nav; 
?>	
	</div>
</div>
</div>

<?
include("ads.php"); 
include("footer.php"); 
?>