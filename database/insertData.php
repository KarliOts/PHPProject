<?php
session_start();
error_reporting(E_ALL^E_NOTICE);

class insertingDataToDatabase {

	private $D_hostname;
	private $D_username;
	private $D_password;
	private $D_database;
	private $connect;
	private $loginUserID;
	//buitlding connection between logged in user and database
	function __construct($host, $user, $pass, $data, $loginUser) {
		$this->D_hostname = $host;
		$this->D_username = $user;
		$this->D_password = $pass;
		$this->D_database = $data;
		$this->loginUserID = $loginUser;
		insertingDataToDatabase::makeConnectionToDatabase();
	}

	public function makeConnectionToDatabase() {
		$connection = new mysqli($this->D_hostname, $this->D_username, $this->D_password, $this->D_database) or die (insertingDataToDatabase::showErrorMessage("Cant connect to database."));
		$this->connect = $connection;
	}
	//adding friend to logged in user
	public function addFriend($userId, $friendId){
		$insertFriend = $this->connect->prepare("INSERT INTO friends (user_id,friend_id)VALUES('$userId','$friendId')");
		$insertFriend->execute();
	}
	//adding song to logged is users selected plalist
	public function addSongToPlaylist(){
		$insertSongToSelectedPlaylist->$this->connect->prepare("INSERT INTO songs_in_playlist (playlist_id, song_url)VALUES('$selectedPlaylist','$selectedVideoUrl')");
		$insertSongToSelectedPlaylist->execute();
	}

	public function showErrorMessage($errorMessage){
		echo $errorMessage;
	}
}
$insertData = new insertingDataToDatabase('127.0.0.1','karli','Ametik00l','karli','1');
$insertData->addFriend($userId, $friendId);

?>