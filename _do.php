<?php

	if(!$api){
		/* Include libraries */
		include_once "lib/api.php";
		
		/* Load API and database */
		$api = new API;
	}
	
	$_GET['q'] = $api->FormatMark($_GET['q'], api::DECIMAL);

	$api->Heading("Výpis známek");
	$api->ViewMarks($_GET['q']);

	$api->Heading("Vážený průměr");
	$api->ViewAverage();
	
    $api->Heading("<h2>Změna známky</h2>");
	$api->ViewChange($_GET['q']);
	
    $api->Heading("<h2>Budoucí známka</h2>");

 	?>
	
	<script src="http://code.jquery.com/jquery-1.4.2.min.js" type="text/javascript"></script>
	<form action="index.php" action="get" onsubmit="ajaxcountf(); return false;">
	<input type="hidden" name="q" id="qx" value="<?php echo $_GET['q']; ?>">
	<strong style="font-size: 11px;">Zadej váhu známky:</strong>&nbsp;&nbsp;<input type="text" class="entry" id="future" name="future" style="width: 100px; padding: 3px;">
	<input type="submit" value="Spočítej" class="send" style=" padding: 2px;">
	</form>
	<div id="inloader">
		<?php if(isset($_GET['future'])) include "_ft.php"; ?>
	</div>

<?php
    $api->Heading("<h2>Přímý odkaz</h2>");
	$api->ViewLink();
?>