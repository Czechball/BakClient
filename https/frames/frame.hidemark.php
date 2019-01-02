<?php

	session_start();
	$index = intval($_GET['index']);
	$markIndex = intval($_GET['markIndex']);
	
	if($index == 0) $_SESSION['hiddenMarks'] = Array();
	else $_SESSION['hiddenMarks'][$index][$markIndex] = !((bool)($_SESSION['hiddenMarks'][$index][$markIndex]));
?>