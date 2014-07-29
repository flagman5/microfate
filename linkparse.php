<?
	
	if(isset($_POST['submit'])) {
	
	
		$link = $_POST['link'];
		
		//check validity of link first
		if(strpos($link, 'www.wretch.cc/album/show.php') == false) {
			echo "problem";
		}
		
		$string = file_get_contents($link);
		
		$part1 = explode(".jpg", $string);
		
		$part2 = explode("<img id='DisplayImage'", $part1[0]);
		
		//echo $part2[1];
		
		$image_link = substr($part2[1], 6);
		
		$image_link .= ".jpg";
		
		echo '<img src="'. $image_link .'">';
	}
	
	
?>
	
	
	
	<form method="POST">
	
	<input type="text" name="link" size="30">
	
	
	<input type="submit" name="submit" value="submit">
	
	
	</form>