 <?php

include dirname(__FILE__)."/../launcher.php";

$auth   = $network -> pageSubmitData($_SESSION['username'], $_SESSION['password']);
$result = $network -> pageLogin();
$result = $network -> pageSubmit($auth);
$result = $network -> pageLanding();
echo $result;
die();
$result = $network -> httpsRequest($network -> urlMarks);

$name 	= Parser :: parseName($result);
$session -> setName($name);

$result = Parser :: parseMarkTable($result);
$result = Parser :: splitTable($result);

echo '<h1>Seznam známek</h1>';
echo '<a href="#" id="moznosti"><img src="img/2moznosti.png"></a><br class="clear">';

echo '<table class="box">';
foreach($result as $index => $singleSubject)
{
	if($index > 0)
	{
		
		$subjectName = Parser :: parseSubject($singleSubject);
		$subjectMarks = Parser :: parseMarks($singleSubject, $index);
		
		echo '<tr><th><div><a href="#" onclick="frame_details('.$index.');">'.$subjectName.'</a><br><strong>'.sprintf("%01.2f", round($math ->  Get_average($subjectMarks, $_SESSION['addedMarks'][$index]), 2)).'</strong></div><td class="filled">';
		$i = 0;
		foreach($subjectMarks as $mark)
		{
			if($mark[2] == 2) $classname = "skryta";
			elseif($mark[2] == 1) $classname = "nova";
			else $classname = "";
			
			echo '<div class="markgroup '.$classname.'" title="'.$mark[3].'" data-subject="'.$index.'" data-mark="'.$i.'"><span class="mark">'.$mark[0] . '</span> <span class="weight">váha '.$mark[1].'</span></div>';
			$i++;
		}
		if(!empty($_SESSION['addedMarks'][$index]))
		{
			$i = 0;
			foreach($_SESSION['addedMarks'][$index] as $mark)
			{
				echo '<div class="markgroup blue" title="Známka přidaná zde, není na rodice.gymspit.cz." data-subject="'.$index.'" data-mark="'.$i.'"><span class="mark">'.$mark[0] . '</span> <span class="weight">váha '.$mark[1].'</span></div>';
				$i++;
			}
		}
		echo "<tr class='mezera'><td colspan=2>";
	}
}
echo '</table><br class="clear">';

?>