	<div class="login-in">
	<h1>Přihlášení</h1>
	<br class="clear">
	<div class="login-head">
		<p>
			<?php if(isset($_GET['wrong'])) echo '<strong style="color: red;">Pravděpodobně jste zadali špatné údaje.</strong><br>'; ?>
			Zadávejte stejné údaje, jako na rodice.gymspit.cz. Nic (ani údaje, ani známky, vážně nic) nebude ukládáno.
		</p>
	</div>
	<div class="login-body">
		<form action="./" method="post" onsubmit="frame_login(); return false;" id="loginform">
		<input placeholder="Jméno" type="text" class="big" name="username" id="username">
		<input placeholder="Heslo" type="password" class="big" name="password" id="password">
		<input type="submit" value="Přihlásit se" class="big">
		</form>
	</div>
	</div>