<?php
	session_start();
	error_reporting(E_ALL ^ E_NOTICE);
	class userRegister {

		//defining database login information
		private $hostname;
		private $username;
		private $password;
		private $database;
		private $connection;

		//defining register information
		private $Rusername;
		private $Rpassword;
		private $Rpassword_control;
		private $Rfirstname;
		private $Rlastname;
		private $Remail;

		//building object
		function __construct ($host, $user, $pass, $data) {
			$this->hostname = $host;
			$this->username = $user;
			$this->password = $pass;
			$this->database = $data;
			userRegister::makeConnection();
		}

		//opening database connection
		public function makeConnection () {
			$this->connection = new mysqli($this->hostname, $this->username, $this->password, $this->database) or die (userRegister::errorMessage('cant connect to database'));
			$this->connection->query('SET NAMES utf8');
		} 

		//getting user information and defining them
		public function getUserInformation ($eUser, $ePass, $ePassC, $eFirst, $eLast, $eEmail) {
			$this->Remail = $eEmail;
			$this->Rusername = $eUser;
			$this->Rpassword = $ePass;
			$this->Rpassword_control = $ePassC;
			$this->Rfirstname = $eFirst;
			$this->Rlastname = $eLast;
			userRegister::checkingUserInformation();
		}

		//lets check all user entered information
		public function checkingUserInformation () {
			//checking username length
			if ((strlen($this->Rusername) > 20) || (strlen($this->Rusername) < 6)) {
				userRegister::errorMessage('Kasutajanimi peab olema vahemikus 6 - 20 tähemärki!');
			}
			//checking if passwords match
			if ($this->Rpassword != $this->Rpassword_control) {
				userRegister::errorMessage('Paroolid peavad kattuma!');
			}
			//checking password length
			if ((strlen($this->Rpassword) < 8) || (strlen($this->Rpassword_control) < 8)) {
				userRegister::errorMessage('Parool soovitavalt pikem kui 8 tähemärki!');
			}
			//validating email
			if (!preg_match('/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*(\.[a-z]{2,3})$/', $this->Remail)) {
				userRegister::errorMessage('Vale email!');
			} else {
				//checking if username or email already exists
				userRegister::emailCheck();
			}
		}

		//checking if email already exists
		public function emailCheck () {
			$checkEmail = $this->connection->prepare("SELECT email FROM users WHERE email='$this->Remail'");
			$checkEmail->bind_result($eMail);
			$checkEmail->execute();
			if ($checkEmail->fetch()) {
				userRegister::errorMessage("Email olemas!");
			} else {
				userRegister::usernameCheck();
			}
			
		}
		//checking if username already exists
		public function usernameCheck () {
			$checkUser = $this->connection->prepare("SELECT username FROM users WHERE username='$this->Rusername'");
			$checkUser->bind_result($checkUsername);
			$checkUser->execute();
			if ($checkUser->fetch()) {
				userRegister::errorMessage("kasutajanimi olemas!");
			} else {
				userRegister::registerUser();
			}
		}

		//removing scripts and registring user
		public function registerUser () {
			$this->Remail = htmlspecialchars($this->Remail);
			$this->Rusername = htmlspecialchars($this->Rusername);
			$this->Rpassword = md5(htmlspecialchars($this->Rpassword));
			$this->Rfirstname = htmlspecialchars($this->Rfirstname);
			$this->Rlastname = htmlspecialchars($this->Rlastname);

			$register = $this->connection->prepare("INSERT INTO users (username, password, email, firstname, lastname) VALUES ('$this->Rusername', '$this->Rpassword', '$this->Remail', '$this->Rfirstname', '$this->Rlastname')") or die ("Ei saa registreerida!");
			$register->execute();
		}

		//getting user id
		public function getUserIdForCreatingPlaylists () {
			$id = $this->connection->prepare("SELECT id FROM users WHERE username='$this->Rusername'");
			$id->bind_result($userId);
			$id->execute();
			if ($id->fetch()) { 
				$registeredUserId = $userId; 
				return $registeredUserId; 
			}
		}

		//creating 3 playlists to user
		public function createUserPlaylists ($userId) {
			$createPlaylists = $this->connection->prepare("INSERT INTO playlists (playlist_name, user_id)VALUES('Playlist 1','$userId'),('Playlist 2','$userId'),('Playlist 3','$userId')");
			$createPlaylists->execute();
			userRegister::closeConnection();
			userRegister::errorMessage('Võite sisse logida!');
		}

		//closing databasse connection
		public function closeConnection () {
			return $this->connection->close();
		}

		//if any errors, this function will display it
		public function errorMessage ($error) {
			echo $error;
			die();
		}
	}

	if ($_POST['choose']) {
		$userRegister = new userRegister('127.0.0.1', 'root', '', 'karli');
		$userRegister->getUserInformation($_POST['username'], $_POST['password'], $_POST['password_control'], $_POST['firstname'], $_POST['lastname'], $_POST['email']);
		$userRegister->createUserPlaylists($userRegister->getUserIdForCreatingPlaylists());
	} else {
		header('Location: ../index.php');
	}
?>