<?php
error_reporting(E_ALL ^ E_NOTICE);
if (!isset($_POST['valik'])) {
	header('Location: index.php');
}

if ($_POST['valik'] == "login") {
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	login_control($username, $password);
} else if ($_POST['valik'] == "register"){
	$username = $_POST['username'];
	$password = $_POST['password'];
	$password_control = $_POST['password_control'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	register_control($username, $password, $firstname, $lastname, $password_control, $email);
}

function login_control($username, $password) {
	$yhendus = new mysqli('127.0.0.1','karli','Ametik00l','karli') or die ('Ei suutnud andmebaasiga yhendada');
	$kontroll = $yhendus->prepare("SELECT id FROM kasutajad WHERE username='$username' AND password='$password'");
	$kontroll->bind_result($id);
	$kontroll->execute();
	if ($kontroll->fetch()) {
	 	session_start();
	 	$_SESSION['user'] = $id; 
	 	$yhendus->close();
	} else {
		error_message("ERROR");
		$yhendus->close();
	}
}

function register_control($username, $password, $firstname, $lastname, $password_control, $email){
	if (!empty($username) && !empty($password) && !empty($firstname) && !empty($lastname) && !empty($password_control) && !empty($email)) {
		/*PAROOLI VALIDEERIMINE*/
		if(strlen($password) < 8 || strlen($password_control) < 8) {
			error_message("Parool peab olema vähemalt 8 tähemärki.");
		}
		if($password_control != $password) {
			error_message("Paroolid peavad kattuma.");
		}
		/*KASUTAJANIME VALIDEERIMINE*/
		if (strlen($username) >= 20 || strlen($username) <= 6) {
			error_message("Kasutajnimi peab olema vahemikus 6 - 20 tähemärki.");
		}
		/*EMAILI VALIDEERIMINE*/
		if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email)) {
			error_message("vale email.");
		}
		
		/*ANDMED VALIDEERITUD LIIGUME REGISTREERIMISE POOLE PEALE*/
		$password = md5(htmlspecialchars($password));
		$username = htmlspecialchars($username);
		$firstname = htmlspecialchars($firstname);
		$lastname = htmlspecialchars($lastname);
		
		user_check($username, $password, $firstname, $lastname, $email);

	} else {
		error_message("täida kõik väljad.");
	}
}

function user_check($username, $password, $firstname, $lastname, $email){
	$connection = new mysqli('127.0.0.1','karli','Ametik00l','karli') or die (error_message('Ei suutnud andmebaasiga ühendada'));
	$c_user_check = $connection->prepare("SELECT * FROM kasutajad");
	$c_user_check->bind_result($c_id, $c_username, $c_password, $c_email, $c_firstname, $c_lastname);
	$c_user_check->execute();
	$email = strtolower($email);
	$username = strtolower($username);
	while($c_user_check->fetch()){
		$c_email = strtolower($c_email);
		$c_username = strtolower($c_username);

		if($c_username == $username){
			error_message("Kasutajanimi olemas!");
		} else if($c_email == $email){
			error_message("email olemas!");
		}		
	}
	register_user($username, $password, $firstname, $lastname, $email);
}

function register_user($username, $password, $firstname, $lastname, $email){
	$connection = new mysqli('127.0.0.1','karli','Ametik00l','karli') or die (error_message('Ei suutnud andmebaasiga ühendada'));
	$insert = $connection->prepare("INSERT INTO kasutajad (username, password, email, firstname, lastname) VALUES ('$username', '$password', '$email', '$firstname', '$lastname')") or die (error_message("Ei suutnud registreerida"));
	$insert->execute();
	create_playlists($connection, $username);
}

function create_playlists($connection, $username){
	$id = $connection->prepare("SELECT id FROM kasutajad WHERE username='$username'");
	$id->bind_result($u_id);
	$id->execute();
	if($id->fetch()){ $c_user_id = $u_id; }
	$connection->close();

	$connection = new mysqli('127.0.0.1','karli','Ametik00l','karli');
	$create_playlist = $connection->prepare("INSERT INTO playlists (playlist_name, user_id)VALUES('Playlist 1','$c_user_id'),('Playlist 2','$c_user_id'),('Playlist 3','$c_user_id')");
	$create_playlist->execute();
	$connection->close();
	error_message("võite sisse logida");
}

function error_message($message){
	echo $message;
	die;
}
?>