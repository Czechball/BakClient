<?php
include dirname(__FILE__)."/../launcher.php";

echo '<h1>Absence</h1><a href="#" id="moznosti"><img src="img/2moznosti.png"></a><br class="clear">';

$auth   = $network -> pageSubmitData($_SESSION['username'], $_SESSION['password']);
$result = $network -> pageLogin();
$result = $network -> pageSubmit($auth);
$result = $network -> pageLanding();

$POSTDATA['__EVENTVALIDATION'] = '/wEWDAKA/86TBwKDtq3hAQKhwpIcAsfC2P0PApLM+NACAofSvNIJAsm+g+sGAszHwr0HAvXLrJgJAtKdzbgLAqmVrNYOAvmW4OYIpnBn8xNiw6dcH9Ssb+J5bNSlP//NZ3sj5WLSStwXwhI=';
$POSTDATA['__EVENTARGUMENT'] = '';
$POSTDATA['__VIEWSTATE'] = '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';
$POSTDATA['__EVENTTARGET'] = '';
$POSTDATA['ctl00$cphmain$listdobaoml'] = 'pololetí';
$POSTDATA['ctl00$cphmain$listjakoml'] = 'seznam';

$result = $network -> httpsRequest($network->urlAbsence, $POSTDATA);
$result = Parser :: parseAbsenceTable($result);

echo '<div class="box" style="width: 430px; float: left;">';
echo '<h2>Průběžná absence</h2>';
echo $result;
echo '</div></div>';

$result = $network -> httpsRequest($network->urlAbsence2);
$result = Parser :: parseAbsenceTable2($result);

echo '<div class="box" style="width: 350px; float: right;">';
echo '<h2>Zameškanost</h2>';
echo $result;
echo '</div><br class="clear">';
?>