<?php

	if(!$api){
		/* Include libraries */
		include_once "lib/api.php";
		
		/* Load API and database */
		$api = new API;
	}

	$api->ViewFuture();
?>