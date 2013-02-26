<?php
session_start();
if(isset($_POST['selectVal'])){
	$selected_playlist = $_POST['selectVal'];
	$selected_video_url = $_POST['video_url'];
	$user_id = $_SESSION['user'];
	if($selected_playlist != ''){
		$connection = new mysqli('127.0.0.1','karli','Ametik00l','karli') or die ('Ei suutnud andmebaasiga ühendada');
		$add_to_playlist = $connection->prepare("INSERT INTO songs_in_playlist (playlist_id, song_url)VALUES('$selected_playlist','$selected_video_url')");
		$add_to_playlist->execute();
		$connection->close();
	}
} else {
	$selected_friend = $_POST['friend'];
	$selected_video_url = 'VIDEO:'.$_POST['video_url'];
	$user_id = $_SESSION['user'];
	if($selected_friend != ''){
		$connection_2 = new mysqli('127.0.0.1','karli','Ametik00l','karli') or die ('Ei suutnud andmebaasiga ühendada');
		$add_friend = $connection_2->prepare("INSERT INTO recommendations (user_id, recommendation, friend_id, done_or_not)VALUES('$user_id','$selected_video_url', '$selected_friend', '0')")or die('viga');
		$add_friend->execute();
		$connection_2->close();
	}
}
?>