<?include("header.php");
include("city_lookup.php");
$city = form($_GET['city']);
if(empty($city)) {
	$condition = "";
	$city_title = "全台灣";
}
else {
	$condition = " WHERE `city`='$city'";
	$city_title = city_lookup($city);
}

if(isset($_GET["show_op"])) { //user requests types of posts
	
	$show_type = $_GET["show_op"];
	
	if($show_type == 1) {	//guy for girl
		if(empty($condition)) {
			$condition = "WHERE `searcher`='1' AND `target`='2'";
		}
		else {
			$condition .= "AND `searcher`='1' AND `target`='2'";
		}
	}
	if($show_type == 2) {	//girl for guy
		if(empty($condition)) {
			$condition = "WHERE `searcher`='2' AND `target`='1'";
		}
		else {
			$condition .= "AND `searcher`='2' AND `target`='1'";
		}
	}
	if($show_type == 3) {	//guy for guy
		if(empty($condition)) {
			$condition = "WHERE `searcher`='1' AND `target`='1'";
		}
		else {
			$condition .= "AND `searcher`='1' AND `target`='1'";
		}
	}
	if($show_type == 4) {	//girl for girl
		if(empty($condition)) {
			$condition = "WHERE `searcher`='2' AND `target`='2'";
		}
		else {
			$condition .= "AND `searcher`='2' AND `target`='2'";
		}
	}
}
	

?>

<div id="mainbar"><?echo $city_title?></div>

<div id="main">

<h1>最新的尋人文章</h1>
<div id="gaim">
<img src="images/gaim.png" border="0">
</div>
<?
	$Limit = 20; //Number of results per page

	$page=$_GET["page"]; //Get the page number to show
	
	If($page == "") $page=1; //If no page number is set, the default page is 1

	//Get the number of results
	$SearchResult=mysql_query("SELECT * FROM `posts` $condition ORDER BY date DESC") or die(mysql_error());
	$NumberOfResults=mysql_num_rows($SearchResult);

	//Get the number of pages
	$NumberOfPages=ceil($NumberOfResults/$Limit);

	//Get only the relevant info for the current page using LIMIT
	$post_results=mysql_query("SELECT * FROM `posts` $condition ORDER BY date DESC LIMIT " . ($page-1)*$Limit . ",$Limit") or die(mysql_error());

	//Print the Titles
	$num = mysql_num_rows($post_results);
	
	if($num == 0) {
		echo "<div id=\"post_headline\">";
		
		echo "無";
		
		echo "</div>";
	}
	else {
		
		for($i=0;$i<$num;$i++) {
			
			$postid =  mysql_result($post_results, $i, "postid");
			echo "<div id=\"post_headline\">";
			
			$subject =  mysql_result($post_results, $i, "subject");
			
			echo "<a href=\"view_post.php?postid=$postid\" style=\"color:".randColor().'">'.$subject."</a>";
			
			$city_post = mysql_result($post_results, $i, "city");
			
			//look up city in table
			
			$city_name = city_lookup($city_post);
	
			echo " 在 ".$city_name;
	  
			$searcher =  mysql_result($post_results, $i, "searcher");
			$target =  mysql_result($post_results, $i, "target");
			
			if($searcher == 1) {
				echo " 男尋";
			}
			else {
				echo " 女尋";
			}
			
			if($target == 1) {
				echo "男";
			}
			else {
				echo "女";
			}
			
			echo "</div>";
		}
		
	}
		function randColor()
		{
			$letters = "1234567890ABCDEF";
			for($i=0;$i<6;$i++)
			{
				$pos = rand(0,15);
				$str .= $letters[$pos];
			}
				return "#".$str;
		}

	//Create and print the Navigation bar
	$Nav="";
	echo "<center>";
	For($i = 1 ; $i <= $NumberOfPages ; $i++) {
		If($i == $page) {
			$Nav .= "<B>$i</B>";
		}
		Else{
			if(empty($city)) {
			
				$Nav .= "<A HREF=\"view_post_city.php?page=" . $i . "\">$i</A>";
			}
			else {
				$Nav .= "<A HREF=\"view_post_city.php?page=" . $i . "city=$city\">$i</A>";
			}
		}
	}
	Echo "頁" . $Nav; 
	echo "</center>";
		
?>

</div>
<div id="adbar">篩選文章</div>
<div id="searchbox">
<span style="margin:10px;">我只要看:</span>
<form name="searchbox" method="GET" style="margin-left:15px; margin-top:10px;">

<input type="radio" name="show_op" value="1">
男尋女
<br/>
<input type="radio" name="show_op" value="2">
女尋男
<br/>
<input type="radio" name="show_op" value="3">
男尋男
<br/>
<input type="radio" name="show_op" value="4">
女尋女
<br/>

<input type="submit" name="submit" value="找">
<input type="hidden" name="city" value="<?echo $city?>">
</form>




</div>

<?include("ads.php")?>

<?include("footer.php");?>