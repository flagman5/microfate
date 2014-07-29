 <?include("header.php");
 include("city_lookup.php");?>


<div id="mainbar">微‧妙‧的‧緣‧份</div>
<div id="mainindex">
<h1>最新的尋人文章</h1>
<div id="gaim">
<img src="images/eyes.png" border="0">
</div>
<div id="scroller_container">
	  <div id="scroller">
	  <?
		$sql = "SELECT * FROM posts ORDER by date DESC LIMIT 10";
		$post_results = mysql_query($sql) or die(mysql_error());
		
		$num = mysql_num_rows($post_results);
		
		for($i=0;$i<$num;$i++) {
			
			$postid =  mysql_result($post_results, $i, "postid");
			echo "<div id=\"post_headline\">";
			
			$subject =  mysql_result($post_results, $i, "subject");
			
			echo "<a href=\"view_post.php?postid=$postid\" style=\"color:".randColor().'">'.$subject."</a>";
			
			$city = mysql_result($post_results, $i, "city");
			
			//look up city in table
			
			$city_name = city_lookup($city);
	
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
	?>
	  
      </div>
    </div>
</div>

<?include("ads.php")?>

<?include("footer.php");?>  
