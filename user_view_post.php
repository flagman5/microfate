<?php


if (!isset($_COOKIE['mfcookie'])) { // User is not logged in.
	header("Location: index.php"); // Goes to main page.
	exit(); // Stops the rest of the script.
} 
//get cookie info
$user_id = $_COOKIE["mfcookie"];

//get success messages
$success = $_GET["success"];
if($success == 1) {
	$success_message = "您的文章已修改了";
}
if($success == 2) {
	$success_message = "您的文章已刪除了";
}

include("header.php"); // Includes the db and form info.

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
include("city_lookup.php");
?>


<div id="mainbar">我的文章</div>
<div id="mainlogin">

  <?if(!empty($success_message)) {
?>	<center>
	<div id="sucess_msg">
	<img src="images/checked.gif"><br/>
	<?echo $success_message?>
	</div>
	</center>
<?}?>

<div id="mailcenter">
	
	<table id="posts" class="tablesorter"> 
		<thead> 
		<tr> 
			<th>主旨</th> 
			<th>城市</th> 
			<!--<th>地點</th> -->
			<th>日期</th> 
			<th>修改</th> 
			<th>刪除</th> 
		</tr> 
		</thead> 
		<tbody> 
	<?
	$Limit = 10; //Number of results per page

	$page=$_GET["page"]; //Get the page number to show
	
	If($page == "") $page=1; //If no page number is set, the default page is 1

	//Get the number of results
	$SearchResult=mysql_query("SELECT * FROM `posts` WHERE `user_id`='$user_id' ORDER BY date DESC") or die(mysql_error());
	$NumberOfResults=mysql_num_rows($SearchResult);

	//Get the number of pages
	$NumberOfPages=ceil($NumberOfResults/$Limit);

	//Get only the relevant info for the current page using LIMIT
	$user_posts=mysql_query("SELECT * FROM `posts` WHERE `user_id`='$user_id' ORDER BY date DESC LIMIT " . ($page-1)*$Limit . ",$Limit") or die(mysql_error());
	
	/*
	$sql = "SELECT * FROM posts WHERE user_id='$user_id' ORDER by date DESC";
	$user_posts = mysql_query($sql) or die(mysql_error());
	*/
	$num = mysql_num_rows($user_posts);
	
	if($num == 0) {
		echo "<tr>";
		echo "You have no posts";
		echo "</tr>";
	}
	else {
		
		for($i=0;$i<$num;$i++) {
			
			echo "<tr>";
			
			$postid = mysql_result($user_posts, $i, "postid");
			
			$subject =  mysql_result($user_posts, $i, "subject");
			
			echo "<td>";
			echo "<a href=\"view_post.php?postid=$postid\">$subject</a> ";
			echo "</td>";
			
			$city = mysql_result($user_posts, $i, "city");
			$city_name = city_lookup($city);
			//look up city in table
			
			echo "<td>";
			echo $city_name;
			echo "</td>";
			/*
			$location =  mysql_result($user_posts, $i, "location");
			
			echo "<td>";
			echo $location;
			echo "</td>";
			*/
			$date =  mysql_result($user_posts, $i, "date");
			
			echo "<td>";
			echo $date;
			echo "</td>";
			
			echo "<td>";
			echo "<a href=\"edit_post.php?postid=$postid\" class=\"thickbox\">修改</a> ";
			echo "</td>";
			
			echo "<td>";
			echo "<a href=\"delete_post.php?postid=$postid&height=150\" class=\"thickbox\">刪除</a> ";
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
		
		For($i = 1 ; $i <= $NumberOfPages ; $i++) {
			If($i == $page) {
				$Nav .= "<B>$i</B>";
			}
			Else{
				if(empty($city)) {
				
					$Nav .= "<A HREF=\"user_view_post.php?page=" . $i . "\">$i</A>";
				}
				else {
					$Nav .= "<A HREF=\"user_view_post.php?page=" . $i . "city=$city\">$i</A>";
				}
			}
		}
	Echo "頁" . $Nav; 
?>
		
	<!--<div id="pager1" class="pager">
	<form>
		<img src="images/first.png" class="first"/>
		<img src="images/prev.png" class="prev"/>
		下十頁
		<img src="images/next.png" class="next"/>
		<img src="images/last.png" class="last"/>
		<select class="pagesize">
			<option selected="selected"  value="10">10</option>

			<option value="20">20</option>
			<option value="30">30</option>
			<option  value="40">40</option>
		</select>
	</form>

	</div>-->
</div>
</div>
<?
include("ads.php"); 
include("footer.php"); 
?>