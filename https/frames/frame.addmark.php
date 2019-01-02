<?php

	session_start();

	$znamka = $_GET['znamka'];
	$vaha = intval($_GET['vaha']);
	$index = intval($_GET['index']);
	
	$_SESSION['addedMarks'][$index][] = Array($znamka, $vaha);
?>