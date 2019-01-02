<?php

	/* Include libraries */
	include_once "lib/api.php";
	include_once '../facebook-platform/facebook.php';
	
	/* Load API and database */
	$api = new API;
	
	/* Create a FB instance */
	$facebook = new Facebook(api::api_key, api::secret);    
	$user = $facebook->get_loggedin_user();
		
	if (!$user)	  				 $facebook->redirect($facebook->get_login_url(api::app_url, 1));	// Equivalent to require_login
//	if (!$facebook->in_frame())	 $facebook->redirect(api::app_url, 1); // Equivalent to require_frame

	/* Connect Facebook to API */
	$api->SetFB($facebook, $facebook->require_login());
	
?><!DOCTYPE HTML>
<html lang="cs">
<head>

	<META http-equiv="Content-Type" content="text/html; charset=utf-8">
	<META name="author" content="Pavel 'w3m' Surý">

	<title>AVG via WeckoProjects</title>
	<META name="description" content="Výpočet váženého průměru.">
	<META name="keywords" content="AVG, průměr, váha">

	<META name="robots" content="index,follow">

	<link rel="shortcut icon" href="http://projects.wecko.net/favicon.ico">
	
	<script src="http://code.jquery.com/jquery-1.4.2.min.js" type="text/javascript"></script>
	<script type="text/javascript">
			function ajaxcount() {
			$('#loader').load("_do.php?q="+$('#promode').val().replace(/ /g, '+'), function(response, status, xhr) {
				$('#loader').hide();
				$('#loader').animate({opacity:'show'}, 200);	
				if (status == "error") {
					var msg = "Sorry but there was an error: ";
					$("#loader").html(msg + xhr.status + " " + xhr.statusText);
			}});
		}

		function ajaxcountf() {
			$('#inloader').load("_ft.php?q="+$('#qx').val().replace(/ /g, '+')+"&future="+$('#future').val(), function(response, status, xhr) {
				$('#inloader').hide();
				$('#inloader').animate({opacity:'show'}, 200);	
				if (status == "error") {
					var msg = "Sorry but there was an error: ";
					$("#inloader").html(msg + xhr.status + " " + xhr.statusText);
			}});
		}

	</script>
	
	<style type="text/css">
      body{
            /*background-color: #EBEFE0;*/
			background-color: #ffffff;
            color: #555555;
            font-family: Arial;
            font-size: 12px;
            text-align: center;
      }
      #in{
            background-color: #ffffff;
            margin: 0 auto;
            text-align: center;
            width: 500px;
            margin-top: 50px;
            margin-bottom: 50px;
            border: 4px solid #B5BACF;
            padding: 1px;
			-webkit-border-radius: 13px;
			-moz-border-radius: 13px;
			border-radius: 13px;
			}
      #inin{
            padding: 30px;
			padding-bottom: 10px;
            text-align: left;
            border: 1px solid #838BAF;
			-webkit-border-radius: 9px;
			-moz-border-radius: 9px;
			border-radius: 9px;
      } 
      h1{
            color: #3B5998;
            font-size: 23px;
            font-weight: normal;
            margin-top: 0px;
            margin-bottom: 0px;
      }
      h2{
            color: #667766;
            font-size: 14px;
            font-weight: bold;
            margin-top: 0px;
            margin-bottom: 5px;
			font-style: italic;
      }
      .entry{
			font-family: Arial;
            border: 1px solid #A7B6DF;
            color: #919F6D;
            padding: 6px;
            font-size: 12px;
            width: 350px;
			-webkit-border-radius: 4px;
			-moz-border-radius: 4px;
			border-radius: 4px;
      }
      .entry:hover, input.entry:focus{
            border: 1px solid #626E8F;
            color: #656F4C;
      }
      th{
            padding: 4px;
			font-family: Arial;
            font-weight: bold;
            color: #3B3F27;
            font-size: 11px;
            text-align: left;
      }
      td.fill{
            height: 15px;
      } 
      input.send{
			-moz-box-shadow: 1px 1px 5px #ddd;
			-webkit-box-shadow: 1px 1px 5px #ddd;
			box-shadow: 1px 1px 5px #ddd;

            border:1px solid #27354F;
			background-color: #5378BF;
			text-shadow: 1px 1px 1px #606C8B;
            color: #ffffff;
            padding: 5px;
            font-size: 12px;
			font-weight: bold;
			font-family: Arial;
			-webkit-border-radius: 4px;
			-moz-border-radius: 4px;
			border-radius: 4px;
			filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#678ACF', endColorstr='#5F80BF'); /* for IE */
			background: -webkit-gradient(linear, left top, left bottom, from(#678ACF), to(#5F80BF)); /* for webkit browsers */
			background: -moz-linear-gradient(top,  #678ACF,  #5F80BF); /* for firefox 3.6+ */

      }
      input.send:hover, input.send:focus{
			filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#5F80BF', endColorstr='#678ACF'); /* for IE */
			background: -webkit-gradient(linear, left top, left bottom, from(#5F80BF), to(#678ACF)); /* for webkit browsers */
			background: -moz-linear-gradient(top,  #5F80BF,  #678ACF); /* for firefox 3.6+ */
			cursor: pointer;
      }

      .linx{
            background-color: #D3DFB5;
            color: #737F57;
            padding: 2px; 
			font-weight: bold;
			text-align: center;
			text-decoration: none;
            padding-left: 5px;
            padding-right: 5px;
            margin-left: 2px;
			margin-bottom: 3px;
			-webkit-border-radius: 4px;
			-moz-border-radius: 4px;
			border-radius: 4px;
      }
      .linx:hover{
            background-color: #799F1D;
            color: #ffffff;
      } 
	  .xmark{
		text-align: center;
		width: 11px;
		border: 1px solid #A8B3CF;
		background-color: #D1DAEF;
		font-size: 12px;
		padding: 3px;
			-webkit-border-radius: 2px;
			-moz-border-radius: 2px;
			border-radius: 2px;
			font-weight: bold;
	  }
	  .xweight{
		font-size: 12px;
		color: #888888;
		padding: 4px;
		padding-left: 6px;
		padding-right: 23px;
	  }
	a{
		color: #3B5998;
		text-decoration: none;
	}
	a:hover{
		text-decoration: underline;
	}
	.footer{
		color: #888888;
		font-size: 10px;
		text-align: center;
		margin-top: 20px;
	}
	</style>
	
	
</head>
<body>

<div id="in">
<div id="inin">
<h1>Výpočet váženého průměru</h1>
<br>
<form action="index.php" action="get" onsubmit="ajaxcount();return false;">
<input type="text" class="entry" id="promode" name="q">
<input type="submit" value="Spočítej" class="send"><br>
<div class="xweight" style="font-size: 11px;"><?php echo "Ahoj <strong><a href=\"".$api->userProfileURL()."\">" . $api->userName() . "</strong></a>";?>, známky zapisuj ve formátu <em><strong>známka</strong>x<strong>váha</strong></em>. Známky jako 1-, 2- apod. je možné zapsat desetinně i s minusem. Jednotlivé známky odděluj mezerami.
Příklad: <em>1x3 1.5x3 2x1 3x1 1-x2</em></div>
</form>

<div id="loader">
<?php if(isset($_GET['q']))include "_do.php";?>
</div>
<div class="footer">Vytvořil Pavel Surý</div>
</div>
</div>

</body>
</html>