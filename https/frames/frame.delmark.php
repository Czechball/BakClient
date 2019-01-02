<?php

	session_start();
	$index = intval($_GET['index']);
	$markIndex = intval($_GET['markIndex']);
	
	if($index == 0) $_SESSION['addedMarks'] = Array();
	else unset($_SESSION['addedMarks'][$index][$markIndex]);
	?>