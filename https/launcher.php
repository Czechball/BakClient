<?php

	error_reporting(E_ALL ^ E_NOTICE);
	
	if(!isset($rootPath)) $rootPath = dirname(__FILE__) . "/";
	
	require_once $rootPath . "classes/session.class.php";
	require_once $rootPath . "classes/network.class.php";
	require_once $rootPath . "classes/parser.class.php";
	require_once $rootPath . "classes/math.class.php";
	require_once $rootPath . "classes/xor.class.php";
	
	$math	  = new Math;
	$network  = new Network;
	$xorcrypt = new xorCrypt;
	$session  = new Session;
	
	$xorcrypt -> set_key(";^".$_SESSION['username']);

?>