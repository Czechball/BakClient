<?php
error_reporting(E_ALL ^ E_NOTICE);
include "classes/session.class.php";
$session = new Session();
?><!DOCTYPE HTML> 
<html lang="cs"> 
<head> 
 
	<meta charset="UTF-8"> 
	<META name="author" content="Pavel Surý"> 
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

	<title>Rozšíření systému Bakaláři</title> 
 
	<META name="robots" content="index,follow"> 
 
	<link rel="stylesheet" href="style.css" media="all">
	<link rel="stylesheet" href="rozvrh.css" media="all">

	<link href='http://fonts.googleapis.com/css?family=PT+Sans:400,700,400italic,700italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
	<script type="text/javascript" src="https://www.google.com/jsapi"></script>
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="js.js"></script>
 
</head> 
<body>


<div class="in"> 
	<div class="fixed">
		<img src="img/2logo.png" alt="Bakalari">
	</div>
	<div class="fluid">
		<span id="ajaxspace-menu">
		<?php
		if(!empty($_SESSION['username']))
		{
			include "frames/frame.nav.php";
		}
		?>
		</span>
	</div>
	<br class="clear">
<div id="ajaxspace">
<?php 

if(!empty($_SESSION['username']))
{
	$path = "./";
	include "frames/frame.marks.php";
}
else
{
	include "frames/frame.loginbox.php";	
}
 ?>
</div> 

</div>

<div id="modal">
<div class="moznostibox">

	<h2>Možnosti klasifikace</h2>
	<a href="#" class="closelink" onclick="frame_delmark(0,0);">Smazat všechny přidané známky</a><br>
	<a href="#" class="closelink" onclick="frame_hidemark(0,0);">Zobrazit všechny skryté známky</a><br><br>
	
	<h2>Možnosti zobrazení</h2>
	<input type="checkbox"><s> Použít starý vzhled</s><br><br>
	
	<h2>Sledování známek</h2>
	<img src="img/rss-icon.png" alt="RSS" align="left" style="margin-right: 10px; margin-bottom: 5px;" height=24 width=24> <strong>RSS feedem:</strong> V nový verzi blbne. Teď udělali ale něco podobnýho ofic. Bakaláři.<br class="clear">
	<img src="http://www.file-extensions.org/imgs/app-icon/128/8275/google-android-sdk-icon.png" alt="Android" align="left" style="margin-right: 10px;" height=24 width=24> <strong>Android aplikací:</strong> Možná... někdy?
	
	<br><br><br>
	<center><a href="#" class="closelink" id="save">Uložit vše</a> <a href="#" class="closelink" id="close">Zavřít okno</a></center>
</div>
<div class="znamkabox">
</div>
</div>

<br><br>

</body>
</html>