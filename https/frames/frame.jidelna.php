<?php
include dirname(__FILE__)."/../launcher.php";

echo '<h1>Jídelna</h1><a href="#" id="moznosti"><img src="img/2moznosti.png"></a><br class="clear">';

$auth   = $network -> pageSubmitData($_SESSION['username'], $_SESSION['password']);
$result = $network -> pageLogin();
$result = $network -> pageSubmit($auth);
$result = $network -> pageLanding();

$result = $network -> httpsRequest($network -> urlMarks);
$name 	= Parser :: parseName($result);
$session -> setName($name);

$db = mysql_connect("mysql-g1", "w3m", "650750850");
mysql_select_db("sury_p_wecko");

$q = mysql_query("select jidelna_username, jidelna_password from bak_jidelna where bakalari_username = '" . $session -> username . "'");
$a = mysql_fetch_object($q);


//$r = $network -> httpsRequest($network -> urlJidelnaLogin, array("Login" => $a->jidelna_username, "Heslo" => $a->jidelna_password, "PrihlaseniSubmit" => "P%F8ihl%E1sit"));
$r = $network -> httpsRequest("https://jidelna.cz/index.php?page=listek&Zarizeni_ID=260", array("Login" => $a->jidelna_username, "Heslo" => $a->jidelna_password, "PrihlaseniSubmit" => "P%F8ihl%E1sit"));
$b = Parser::getFood ( $r );

print_r($b);

for($i = 0; $i < count($b); $i++)
{
	print("".iconv('windows-1250', 'UTF-8', $b[$i]).'<br><br>');
}
?>
https://jidelna.cz/index.php?page=listek&Zarizeni_ID=260