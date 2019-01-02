 <?php

include dirname(__FILE__)."/../launcher.php";

echo '<h1>Vysvědčení</h1><a href="#" id="moznosti"><img src="img/2moznosti.png"></a><br class="clear">';

$auth   = $network -> pageSubmitData($_SESSION['username'], $_SESSION['password']);
$result = $network -> pageLogin();
$result = $network -> pageSubmit($auth);
$result = $network -> pageLanding();
$result = $network -> httpsRequest($network -> urlVysvedceni);

echo '<div class="box"><div class="border"><table class="vysvedceni">';

$result = Parser :: parseReportTable($result);
$subjects = Parser :: parseReportSubjects($result);
$marks = Parser :: parseReportMarks($result);

$ratio = count($marks[1]) / count($subjects[1]);

$znamka = 0;

foreach($subjects[1] as $key => $subject)
{
	echo "<tr><th>" . $subject;
	$marks = Parser :: parseReportMarks($subjects[2][$key]);
	foreach($marks[1] as $mark)
	{
		$color = "#aaaaaa";
		if($mark == "1") $color = "#00aa00";
		elseif($mark == "2") $color = "#aaaa00";
		elseif($mark == "3") $color = "#aa5500";
		elseif($mark == "4") $color = "#aa0000";
		elseif($mark == "5") $color = "#000000";

		$bgcolor = "transparent";
		if($mark == "1") $bgcolor = "#cceecc";
		elseif($mark == "2") $bgcolor = "#eeeecc";
		elseif($mark == "3") $bgcolor = "#eeddcc";
		elseif($mark == "4") $bgcolor = "#eecccc";
		elseif($mark == "5") $bgcolor = "#cccccc";
		echo "<td style='color: ".$color."; background-color: ".$bgcolor."'>".$mark."";
	}
}
echo '</table></div></div>';

echo '<div class="box"><div class="border"><h2>Průměry známek</h2><p>Započítávají se do něj i nepovinné předměty!</p><div id="chart_div_semester">';

echo '</div></div></div><script>draw_semester_chart()</script>';

?>