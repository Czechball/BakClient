<?php

if(!@$path) $path = "../";
include $path."classes/session.class.php";

new Session($_POST['username'], $_POST['password']);

?>