 <?php

include dirname(__FILE__)."/../launcher.php";

$auth   = $network -> pageSubmitData($_SESSION['username'], $_SESSION['password']);
$result = $network -> pageLogin();
$result = $network -> pageSubmit($auth);
$result = $network -> pageLanding();
$result = $network -> httpsRequest($network -> url . $network -> urlMarks);

$name 	= Parser :: parseName($result);
$session -> setName($name);

$result = Parser :: parseMarkTable($result);
$result = Parser :: splitTable($result);

$index = $_GET['index'];
if(isset($result[$index]))
{
		$singleSubject = $result[$index];
		$subjectName = Parser :: parseSubject($singleSubject);
		$subjectMarks = Parser :: parseMarks($singleSubject, $index);
		echo '<h1>'.$subjectName.'</h1><a href="#" id="moznosti"><img src="img/2moznosti.png"></a><br class="clear">';
		
		$average = $math -> Get_average($subjectMarks, $_SESSION['addedMarks'][$index]);
		echo '<div class="box"><div class="border">';

		$i = 0;
		foreach($subjectMarks as $mark)
		{
			if($mark[2] == 2) $classname = "skryta";
			elseif($mark[2] == 1) $classname = "nova";
			else $classname = "";
			
			echo '<div class="markgroup '.$classname.'" title="'.$mark[3].'" data-subject="'.$_GET['index'].'" data-mark="'.$i.'"><span class="mark">'.$mark[0] . '</span> <span class="weight">váha '.$mark[1].'</span></div>';
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
		echo '<br class="clear"></div></div>';
}
?>

<div class="boxAvg">
<div class="box">
<div class="border" style="height: 100px; ">
	<h2>Přesný průměr</h2>
	<p class="prumer-velky"><?php echo round($average,8);?></p> 
</div>	
</div>

<div class="box">
<div class="border" style="height: 150px;">
	<h2>Skrýt známku</h2>
	<p>Počítáte si, kolik těch dementních mat sem úkolů je potřeba dodatečně dodělat, aby se vám změnila známka? Stačí na tu známku nahoře kliknout!</p>
</div>	
</div>
</div>
<div class="boxAddMark">

	<div class="box">
	<div class="border" style="height: 275px;">
	<h2>Přidat známku</h2>
	<p>Profesoři jsou neskutečně líní, máte už další známku, ale není na internetu? Přidej známku, která ti chybí (přidané známky se zobrazí zeleně a po odhlášení zmizí).</p>
	<br>
	<form action="#" id="markform" onsubmit="frame_addmark(<?php echo $_GET['index'];?>); return false;" style="margin-left: 30px;">
	<input type="hidden" name="soucetvah" value="<?php echo $math->soucetvah;?>">
	<input type="hidden" name="soucetznamek" value="<?php echo $math->soucetznamek;?>">
	<table class="addTable">
	<tr><td>Známka: <td><input type="text" name="znamka"> <br>
	<tr><td>Váha: 	<td><input type="text" name="vaha"> <br>
	<tr><td><td><input type="submit" value="Přidej">
	</table>
	</form>
	</div>
</div>
</div>
<br class="clear hide">
<div class="box" style="clear:both">
<div class="border">

<div class="boxChangeMark">
<h2>Změny známky</h2>
<p>
<i>Vysvětlí mi někdo, co má tohle jako bejt?</i> Vypadá to retardovaně složitě, ale není. Na svislý ose vidíte průměry, na vodorovný ose vidíte známky, v tabulce vidíte váhy. Hodně zelená políčka = velká šance opravit si známku, hodně červená políčka - velká šance si zkazit známku, bílá políčka - mizivá šance, že to známku ovlivní.<br>
</p>
</div>
<table id="chTable">
<tr><th><th>1 <th>1- <th>2 <th>2- <th>3 <th>3- <th>4 <th>4- <th>5
<?php
	for($prumer = 1.5; $prumer <= 4.5; $prumer++)
	{
		echo "<tr><th>" . $prumer;
		for($znamka = 1; $znamka <= 5; $znamka+=0.5)
		{
			if($znamka - $prumer == 0)
			{
				echo "<td style='background-color: #ffffff; color: #aaaaaa;'>x";
				continue;
			}

			$w = $math -> Get_needed_weight($znamka, $prumer, false);
			$wFormatted = $math -> Get_needed_weight($znamka, $prumer, true);
			
			if($w < 0)
			{
				echo "<td style='background-color: #ffffff; color: #aaaaaa;'>x";
			}
			elseif($w == 0)
			{
				echo "<td style='background-color: #ffffff;'>";			
			}
			elseif($w > 0 && $average > $prumer)
			{
				echo "<td style='background-color: ".$math->makeBGColor("green", $w)."; color: ".$math->makeColor("green", $w)."'>".$wFormatted;			
			}
			elseif($w > 0 && $average < $prumer)
			{
				echo "<td style='background-color: ".$math->makeBGColor("red", $w)."; color: ".$math->makeColor("red", $w).";'>".$wFormatted;			
			}
			
		}
	}
?>
</table>
<br class="clear">
</div>
</div>


<div class="box">
<div class="border">
<h2>Možné průměry</h2>
	<p>Zadej sem váhu známky a uvidíš průměry, který ti můžou vyjít.</p>

	<form action="#" id="avgsform" onsubmit="frame_averages(); return false;" style="margin-left: 30px;">
	<input type="hidden" name="soucetvah" value="<?php echo $math->soucetvah;?>">
	<input type="hidden" name="soucetznamek" value="<?php echo $math->soucetznamek;?>">
	Váha: <input type="text" name="vaha"> <input type="submit" value="Spočítat">
	</form>

	<p id="ajaxaverages"></p>
	<br class="clear">
</div>
</div>
