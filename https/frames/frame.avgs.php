<?php

	header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); // Date in the past

	include dirname(__FILE__)."/../launcher.php";

	$vaha = intval($_GET['vaha']);
	
	$math -> soucetvah = $_GET['soucetvah'];
	$math -> soucetznamek = $_GET['soucetznamek'];
	
	echo '<table id="avgs_table">';
	echo '<tr><td>1  <th> ' . $math -> Get_average_with(1,   $vaha);
	echo '<tr><td>1- <th> ' . $math -> Get_average_with(1.5, $vaha);
	echo '<tr><td>2  <th> ' . $math -> Get_average_with(2,   $vaha);
	echo '<tr><td>2- <th> ' . $math -> Get_average_with(2.5, $vaha);
	echo '<tr><td>3  <th> ' . $math -> Get_average_with(3,   $vaha);
	echo '<tr><td>3- <th> ' . $math -> Get_average_with(3.5, $vaha);
	echo '<tr><td>4  <th> ' . $math -> Get_average_with(4,   $vaha);
	echo '<tr><td>4- <th> ' . $math -> Get_average_with(4.5, $vaha);
	echo '<tr><td>5  <th> ' . $math -> Get_average_with(5,   $vaha);
	echo '</table>';
	

	?>
 	<div id="chart_div" style="width: 590px; height: 227px; float: right; margin-right: 10px;"></div>
