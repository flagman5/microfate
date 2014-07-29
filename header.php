<?

if (isset($_COOKIE['mfcookie'])) { // loggedin
	$menu = "<a href=\"logout.php\">登出</a> | <a href=\"create_post.php\">刊登文章</a> | <a href=\"profile.php\">個人檔案</a> | <a href=\"inbox.php\">信箱</a> | <a href=\"manual.php\">使用手冊</a>";
}
else {
	$menu = "<a href=\"login.php\">登入</a> | <a href=\"register.php\">註冊</a> | <a href=\"manual.php\">使用手冊</a>";
}
include("conf.inc.php"); // Includes the db and form info.
?>
<!DOCTYPE html PUBLIC "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<title>微緣 - Microfate - 尋人 找人</title><link rel="shortcut icon" href="" />

<script type="text/javascript" src="js/jquery-1.2.6.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-personalized-1.6rc2.min.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.min.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.pager.js"></script>
<script type="text/javascript" src="js/thickbox-compressed.js"></script>
<script type="text/javascript" src="js/jscroller.0.3.js"></script>
<link href="css/main.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/tabs.css" rel="stylesheet" type="text/css" media="screen" />
<!--[if IE]> <link href="css/tabsIE.css" rel="stylesheet" type="text/css"> <![endif]-->
<link href="css/tables.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/thickbox.css" rel="stylesheet" type="text/css" media="screen" />


</head>
<body>
<div id="topbar">
	<?include("city.html");?>
</div>

<div id="logo"> 
<img src="images/pinkhome.png" border="0" height="60px" style="margin-bottom:50px; margin-right:10px; margin-left:5px;"><a href="index.php"><img src="images/logo3.png" border="0" style="margin-bottom:20px;"></a>
</div>

<div id="login">
<? echo $menu?>
</div>
<div id="banner">
<img src="images/banner.jpg" width="100%">
</div>