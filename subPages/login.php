<?php
error_reporting(E_ALL ^ E_NOTICE);
class userLogin
{
	private $username;
	private $password;
	private $D_hostname;
	private $D_username;
	private $D_password;
	private $D_database;
	private $connect;

	function __construct($host, $user, $pass, $data, $loginUser, $loginPass) {
		$this->D_hostname = $host;
		$this->D_username = $user;
		$this->D_password = $pass;
		$this->D_database = $data;
		$this->username = $loginUser;
		$this->password = $loginPass;
		userLogin::makeConnectionToDatabase();
	}

	public function makeConnectionToDatabase() {
		$connection = new mysqli($this->D_hostname, $this->D_username, $this->D_password, $this->D_database) or die (mysql_error());
		$connection->query('SET NAMES utf8');
		$this->connect = $connection;
		userLogin::loginControl();
	}

	public function loginControl(){
		$searchUser = $this->connect->prepare("SELECT * FROM users WHERE username='$this->username' AND password='$this->password'") or die (mysql_error());
		$searchUser->bind_result($id, $username, $password, $email, $firstname, $lastname);
		$searchUser->execute();
		
		if ($searchUser->fetch()){
			session_start();
			$_SESSION['user'] = $id;
			$this->connect->close();
		} else {
			echo "ERROR";
		}
	}
}

if ($_POST['choose']) {
	$userLogin = new userLogin('127.0.0.1', 'root', '', 'karli', $_POST['username'], md5($_POST['password']));
} else {
	header('Location: ../index.php');
}

//else if ($_POST['valik'] == "register"){
	/*$username = $_POST['username'];
	$password = $_POST['password'];
	$password_control = $_POST['password_control'];
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	register_control($username, $password, $firstname, $lastname, $password_control, $email);
}*/

/*
if (!isset($_POST['valik'])) {
	header('Location: index.php');
}



function login_control($username, $password) {
	$yhendus = new mysqli('127.0.0.1','root','','karli') or die ('Ei suutnud andmebaasiga yhendada');
	$kontroll = $yhendus -> prepare("SELECT id FROM users WHERE username='$username' AND password='$password'");
	$kontroll -> bind_result($id);
	$kontroll -> execute();
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
/*		if(strlen($password) < 8 || strlen($password_control) < 8) {
			error_message("Parool peab olema vähemalt 8 tähemärki.");
		}
		if($password_control != $password) {
			error_message("Paroolid peavad kattuma.");
		}
		/*KASUTAJANIME VALIDEERIMINE*/
/*		if (strlen($username) >= 20 || strlen($username) <= 6) {
			error_message("Kasutajnimi peab olema vahemikus 6 - 20 tähemärki.");
		}
		/*EMAILI VALIDEERIMINE*/
/*		if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/', $email)) {
			error_message("vale email.");
		}
		
		/*ANDMED VALIDEERITUD LIIGUME REGISTREERIMISE POOLE PEALE*/
/*		$password = md5(htmlspecialchars($password));
		$username = htmlspecialchars($username);
		$firstname = htmlspecialchars($firstname);
		$lastname = htmlspecialchars($lastname);
		
		user_check($username, $password, $firstname, $lastname, $email);

	} else {
		error_message("täida kõik väljad.");
	}
}

function user_check($username, $password, $firstname, $lastname, $email){
	$connection = new mysqli('127.0.0.1','root','','karli') or die (error_message('Ei suutnud andmebaasiga ühendada'));
	$c_user_check = $connection->prepare("SELECT * FROM users");
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
	$connection = new mysqli('127.0.0.1','root','','karli') or die (error_message('Ei suutnud andmebaasiga ühendada'));
	$insert = $connection->prepare("INSERT INTO users (username, password, email, firstname, lastname) VALUES ('$username', '$password', '$email', '$firstname', '$lastname')") or die (error_message("Ei suutnud registreerida"));
	$insert->execute();
	create_playlists($connection, $username);
}

function create_playlists($connection, $username){
	$id = $connection->prepare("SELECT id FROM users WHERE username='$username'");
	$id->bind_result($u_id);
	$id->execute();
		if($id->fetch()){ $c_user_id = $u_id; }
	$connection->close();

	$connection = new mysqli('127.0.0.1','root','','karli');
	$create_playlist = $connection->prepare("INSERT INTO playlists (playlist_name, user_id)VALUES('Playlist 1','$c_user_id'),('Playlist 2','$c_user_id'),('Playlist 3','$c_user_id')");
	$create_playlist->execute();
	$connection->close();
	error_message("võite sisse logida");
}

function error_message($message){
	echo $message;
	die;
}*/
?>