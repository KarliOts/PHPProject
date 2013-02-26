<?php
	header('Content-Type: text/event-stream');
	header('Cache-Control: no-cache');
	error_reporting(E_ALL ^ E_NOTICE);
	session_start();
	$user_id = $_SESSION['user'];
	$notification_number = array();
	$i=0;
	$connection = new mysqli('127.0.0.1','karli','Ametik00l','karli') or die ('Ei suutnud andmebaasiga ühendada');
	$notification = $connection->prepare("SELECT id FROM recommendations WHERE friend_id='$user_id' AND done_or_not=0");
	$notification->bind_result($id);
	$notification->execute();
	while($notification->fetch()){
		$notification_number[$i] = $id;
		$i++;
	}
	$number = count($notification_number);
	if($number > 0){
		echo "data: uued teated:\n";
		echo "data:	{$number}\n\n"; 
	}
?>