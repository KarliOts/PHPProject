<?php
session_start();
error_reporting(E_ALL^E_NOTICE);
class insertingDataToDatabase {

	//defining global variables
	private $D_hostname;
	private $D_username;
	private $D_password;
	private $D_database;
	private $connect;
	private $loginUserID;

	//building connection between logged in user and database
	function __construct($host, $user, $pass, $data, $loginUser) {
		$this->D_hostname = $host;
		$this->D_username = $user;
		$this->D_password = $pass;
		$this->D_database = $data;
		$this->loginUserID = $loginUser;
		insertingDataToDatabase::makeConnectionToDatabase();
	}

	//making connection to database
	public function makeConnectionToDatabase() {
		$connection = new mysqli($this->D_hostname, $this->D_username, $this->D_password, $this->D_database) or die (insertingDataToDatabase::showErrorMessage("Cant connect to database."));
		$this->connect = $connection;
	}

	//adding friend to logged in user
	public function addFriend($friendId){
		$insertFriend = $this->connect->prepare("INSERT INTO friends (user_id,friend_id)VALUES('$this->loginUserID','$friendId')");
		$insertFriend->execute();
	}

	//adding song to logged is users selected plalist
	public function addSongToPlaylist($selectedPlaylist, $selectedVideoUrl){
		$insertSongToSelectedPlaylist = $this->connect->prepare("INSERT INTO songs_in_playlist (playlist_id, song_url)VALUES('$selectedPlaylist','$selectedVideoUrl')");
		$insertSongToSelectedPlaylist->execute();
	}
	
	//adding videos to database that user doesnt want to listen right now, but wants to listen them later, maximum 5 videos 1 user
	public function addVideoToListenLater($songUrl){
		$insertVideoToListenLater = $this->connect->prepare("INSERT INTO listenlater (user_id, song_url)VALUES($this->loginUserID, '$songUrl')");
		$insertVideoToListenLater->execute();
        }

        //closing database connection
	public function closeDatabaseConnection(){
		$this->connect->close();
	}

	//shows error message when something goes wrong
	public function showErrorMessage($errorMessage){
		return $errorMessage;
	}
}

$insertData = new insertingDataToDatabase('127.0.0.1','root','','karli', $_SESSION['user']);

if (isset($_POST['choice'])) {
	$TODO = $_POST['choice'];
	if ($TODO == 'playlist') {
		//inserting song to selected playlist max 30 song in 1 playlist
		$insertData->addSongToPlaylist($_POST['playlistId'], $_POST['videoUrl']);
		$insertData->closeDatabaseConnection();
	} else if ($TODO == 'recommend') {
		
	} else if ($TODO == 'later') {
		$insertData->addVideoToListenLater($_POST['videoUrl']);
		$insertData->closeDatabaseConnection();
        } else if ($TODO == 'friend') {
                $insertData->addFriend($_POST['friendId']);
        } else {
		header('Location: ../index.php');
	}
}
?>