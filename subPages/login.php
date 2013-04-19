<?php
error_reporting(E_ALL ^ E_NOTICE);
class userLogin {
	private $username;
	private $password;
	private $D_hostname;
	private $D_username;
	private $D_password;
	private $D_database;
	private $connect;

	function __construct ($host, $user, $pass, $data, $loginUser, $loginPass) {
		$this->D_hostname = $host;
		$this->D_username = $user;
		$this->D_password = $pass;
		$this->D_database = $data;
		$this->username = $loginUser;
		$this->password = $loginPass;
		userLogin::makeConnectionToDatabase();
	}

	public function makeConnectionToDatabase () {
		$connection = new mysqli($this->D_hostname, $this->D_username, $this->D_password, $this->D_database) or die (mysql_error());
		$connection->query('SET NAMES utf8');
		$this->connect = $connection;
		userLogin::loginControl();
	}

	public function loginControl () {
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
?>