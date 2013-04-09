<?php
	error_reporting(E_ALL^E_NOTICE);
	session_start();

	class updateDatabaseInformation {

		//setting user entered values to variables
		private $_USERNAME;
		private $_PASSWORD;
		private $_FIRSTNAME;
		private $_EMAIL;
		private $_LASTNAME;

		//setting up connection variables
		private $_D_HOST;
		private $_D_USER;
		private $_D_PASS;
		private $_D_NAME;
		private $_CONNECTION;

		//if user changes his password
		private $_OLD_PASSWORD;
		private $_NEW_PASSWORD;
		private $_NEW_PASSWORD_TWICE;

		//logged in user id
		private $_LOGGED_IN_USER;

		//building object and setting up connection to database
		function __construct ($host, $user, $pass, $data, $userId) {
			$this->_USERNAME = $_POST['updateUsername'];
			$this->_FIRSTNAME = $_POST['updateFirstname'];
			$this->_LASTNAME = $_POST['updateLastname'];
			$this->_EMAIL = $_POST['updateEmail'];

			$this->_D_HOST = $host;
			$this->_D_USER = $user;
			$this->_D_PASS = $pass;
			$this->_D_NAME = $data;

			$this->_LOGGED_IN_USER = $userId;

			updateDatabaseInformation::validateInformation();
		}

		//check if user entered information is valid
		public function validateInformation () {
			if (strlen($this->_USERNAME) < 6 || strlen($this->_USERNAME) > 20) {
				updateDatabaseInformation::returnMessage('Kasutajanimi peab olema vahemikus 6 - 20 tähemärki! ');
			}

			if (!preg_match('/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*(\.[a-z]{2,3})$/', $this->_EMAIL)) {
				updateDatabaseInformation::returnMessage("vale email! ");
			}

			updateDatabaseInformation::removeAnyScript();
		}

		//removing possible scripts from user entered information
		public function removeAnyScript () {
			$this->_USERNAME = htmlspecialchars($this->_USERNAME);
			$this->_FIRSTNAME = htmlspecialchars($this->_FIRSTNAME);
			$this->_LASTNAME = htmlspecialchars($this->_LASTNAME);
			$this->_EMAIL = htmlspecialchars($this->_EMAIL);

			updateDatabaseInformation::buildConnection();
		}

		//making connection to database
		public function buildConnection () {
			$this->_CONNECTION = new mysqli($this->_D_HOST, $this->_D_USER, $this->_D_PASS, $this->_D_NAME) or die (mysql_error());
			$this->_CONNECTION->query('SET NAMES utf8');

			updateDatabaseInformation::updateInformation();
		}

		//updating logged in user information in database
		public function updateInformation () {
			$update = $this->_CONNECTION->prepare("UPDATE users SET username='$this->_USERNAME', email='$this->_EMAIL', firstname='$this->_FIRSTNAME', lastname='$this->_LASTNAME' WHERE id='$this->_LOGGED_IN_USER'")or die('viga');
			$update->execute();
		}

		//displays message back to user, only error-s
		public function returnMessage ($message) {
			echo $message;
			die();
		}
	}

	$updateDatabaseInformation = new updateDatabaseInformation('127.0.0.1','root','','karli', $_SESSION['user']);
?>