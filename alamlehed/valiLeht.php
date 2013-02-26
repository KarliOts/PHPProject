<?php
session_start();
	$leht = $_POST['leht'];
	if($leht == "Logi välja"){
		session_destroy();
		echo 'exit';
	} else {
		include $leht.'.php'; 
	}
?>