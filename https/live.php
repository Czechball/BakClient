<?php

 if(!$path) $path = "./";
 
 include $path."https.php";
 include $path."xor.php";
 $gymspit = new Gymspit;
 $xorcrypt = new xorCrypt();
 $xorcrypt -> set_key(";^".$_GET['u']);

$auth   = $gymspit -> POST_array($_GET['u'], $xorcrypt -> decrypt($_GET['h']));
$result = $gymspit -> HTTPS_login_page();
$result = $gymspit -> HTTPS_login_proceed($auth);
$result = $gymspit -> HTTPS_get_contents($gymspit->url_marks);

$name = $gymspit->Get_name($result);

if(strpos($name, 'Object moved') !== false)
{
	die("Nepodařilo se přihlásit.");
}

else
{
	header('Content-Type: text/xml');

}

 echo '<?xml version="1.0" encoding="utf-8"?>';
 
 echo '<rss version="2.0">';
 echo '<channel>';
 echo '<title>WEB Bakaláři</title>';
 echo '<webMaster>Pavel Surý</webMaster>';
 echo '<lastBuildDate>'.gmdate("D, d M Y H:i:s").'GMT</lastBuildDate>';



$result = $gymspit -> Get_table($result);

$result = explode('<div class="nazevprdiv">', $result);
foreach($result as $index => $single_subject)
{
	if($index > 0)
	{
		$subject_name = $gymspit -> Get_subject($single_subject);
		$subject_marks = $gymspit -> Get_marks($single_subject);
		
		foreach($subject_marks as $mark)
		{
			if($mark[2] != 'a')
			{
			?>
				<item>
				  <title><?php echo $mark[0] . ' (váha ' . $mark[1] . ')'; ?></title>
				  <link>http://bak.wecko.net/</link>
				  <description><?php echo $subject_name; ?></description>
				</item>
			<?php
			}
		}
	}
}

?>
</channel>
</rss>