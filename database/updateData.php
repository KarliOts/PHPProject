<?php
	error_reporting(E_ALL^E_NOTICE);
	session_start();

	class updateDatabaseInformation {

		//setting user entered values to variables
		private $_USERNAME;
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
		}

		//check if user entered information is valid
		public function validateInformation () {

			if (!preg_match('/^[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*@[_a-zA-Z0-9-]+(\.[_a-zA-Z0-9-]+)*(\.[a-z]{2,3})$/', $this->_EMAIL)) {
				updateDatabaseInformation::returnMessage("vale email! ");
			}
		}

		//removing possible scripts from user entered information
		public function removeAnyScript () {
			$this->_USERNAME = htmlspecialchars($this->_USERNAME);
			$this->_FIRSTNAME = htmlspecialchars($this->_FIRSTNAME);
			$this->_LASTNAME = htmlspecialchars($this->_LASTNAME);
			$this->_EMAIL = htmlspecialchars($this->_EMAIL);
		}

		//making connection to database
		public function buildConnection () {
			$this->_CONNECTION = new mysqli($this->_D_HOST, $this->_D_USER, $this->_D_PASS, $this->_D_NAME) or die (mysql_error());
			$this->_CONNECTION->query('SET NAMES utf8');
		}

		//updating logged in user information in database
		public function updateInformation () {
			$update = $this->_CONNECTION->prepare("UPDATE users SET username='$this->_USERNAME', email='$this->_EMAIL', firstname='$this->_FIRSTNAME', lastname='$this->_LASTNAME' WHERE id='$this->_LOGGED_IN_USER'")or die('viga');
			$update->execute();
		}

		//logged in user have seen frien request
		public function seenFriendRequest ($friendId) {
			$updateRequest = $this->_CONNECTION->prepare("UPDATE notifications SET done_or_not=1 WHERE user_id='$friendId' AND friend_id='$this->_LOGGED_IN_USER' AND recommendation='FRIEND'")or die('mingisugune viga');
			$updateRequest->execute();
		}

		//adding user to friends list after accepting request
		public function addUserToFriendList ($friendId) {
			$addUser = $this->_CONNECTION->prepare("INSERT INTO friends (user_id, friend_id) VALUES ('$this->_LOGGED_IN_USER','$friendId')")or die(mysql_error());
			$addUser->execute();
			updateDatabaseInformation::returnMessage('Lisatud tuttavate listi!');
		}
                //deleting music notification
                public function deleteMusicNotification ($id) {
                    $deleteMusicNotification = $this->_CONNECTION->prepare("DELETE FROM notifications WHERE id='$id'");
                    $deleteMusicNotification->execute();
                    updateDatabaseInformation::returnMessage('Eemaldatud');
                }
                
                //deleting user from friends list
                public function deleteUserFromFriendsList ($friendId) {
                    $deleteFriend = $this->_CONNECTION->prepare("DELETE FROM friends WHERE user_id='$this->_LOGGED_IN_USER' AND friend_id='$friendId'");
                    $deleteFriend->execute(); 
                }

		//closing database connection
		public function closeConnection () {
			$this->_CONNECTION->close();
		}

		//displays message back to user, in case any errors should occur, page will die after going into this function
		public function returnMessage ($message) {
			echo $message;
			die();
		}
	}

	$updateDatabaseInformation = new updateDatabaseInformation('127.0.0.1','root','','karli', $_SESSION['user']);
	
	if ($_POST['updateFirstname'] != '') {
		$updateDatabaseInformation->validateInformation();
		$updateDatabaseInformation->removeAnyScript();
		$updateDatabaseInformation->buildConnection();
		$updateDatabaseInformation->updateInformation();
		$updateDatabaseInformation->closeConnection();
	}

	if (isset($_POST['notify'])) {
		if ($_POST['notify'] == 'accept') {
			$updateDatabaseInformation->buildConnection();
			$updateDatabaseInformation->seenFriendRequest($_POST['friendId']);
			$updateDatabaseInformation->addUserToFriendList($_POST['friendId']);
			$updateDatabaseInformation->closeConnection();
                } else if ($_POST['notify'] == 'removeSong') {
                        $updateDatabaseInformation->buildConnection();
                        $updateDatabaseInformation->deleteMusicNotification($_POST['songId']);
                        $updateDatabaseInformation->closeConnection();
                }
        } 
        if (isset($_POST['choice'])) {
            if ($_POST['choice'] == 'unfriend') {
                $updateDatabaseInformation->buildConnection();
                $updateDatabaseInformation->deleteUserFromFriendsList($_POST['friendId']);
                $updateDatabaseInformation->closeConnection();
            }
        }
?>