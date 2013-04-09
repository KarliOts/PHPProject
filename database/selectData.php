<?php
error_reporting(E_ALL ^ E_NOTICE); 
session_start();
class databaseConnection {
	//defining the variables
	private $D_hostname;
	private $D_username;
	private $D_password;
	private $D_database;
	private $connect;
	private $loginUserID;

	//building and setting up connection to database
	function __construct($host, $user, $pass, $data, $loginUser) {
		$this->D_hostname = $host;
		$this->D_username = $user;
		$this->D_password = $pass;
		$this->D_database = $data;
		$this->loginUserID = $loginUser;
		databaseConnection::makeConnectionToDatabase();
	}

	//connecting to database
	public function makeConnectionToDatabase() {
		$connection = new mysqli($this->D_hostname, $this->D_username, $this->D_password, $this->D_database) or die (databaseConnection::showErrorMessage("Cant connect to database."));
		$connection->query('SET NAMES utf8');
		$this->connect = $connection;
	}
	
	//selecting all users from database
	public function selectUsers() {
		$selectUser = $this->connect->prepare("SELECT * FROM users") or die (databaseConnection::showErrorMessage("Cannot open table users from database."));
		$selectUser->bind_result($id, $username, $password, $email, $firstname, $lastname);
		$selectUser->execute();
		$websiteUserInformation = array();
		$websiteUsers = array();

		while($selectUser->fetch()){
			$websiteUserInformation['id'] = $id;
			$websiteUserInformation['usrname'] = $username;
			$websiteUserInformation['password'] = $password;
			$websiteUserInformation['email'] = $email;
			$websiteUserInformation['firstname'] = $firstname;
			$websiteUserInformation['lastname'] = $lastname;
			$websiteUsers[] = $websiteUserInformation;
		}
		return $websiteUsers;
	}

	//selecting logged in user information
	public function selectLoginUserInformation() {
		$selectUser = $this->connect->prepare("SELECT * FROM users WHERE id='$this->loginUserID'") or die (databaseConnection::showErrorMessage("Cannot open table users from database."));
		$selectUser->bind_result($id, $username, $password, $email, $firstname, $lastname);
		$selectUser->execute();
		$websiteLoginUserInformation = array();

		while($selectUser->fetch()){
			$websiteLoginUserInformation['id'] = $id;
			$websiteLoginUserInformation['username'] = $username;
			$websiteLoginUserInformation['password'] = $password;
			$websiteLoginUserInformation['email'] = $email;
			$websiteLoginUserInformation['firstname'] = $firstname;
			$websiteLoginUserInformation['lastname'] = $lastname;
		}
		return $websiteLoginUserInformation;
	}

	//selecting logged in user playlists
	public function selectLoginUserPlaylists() {
		$selectUserPlaylist = $this->connect->prepare("SELECT * FROM playlists WHERE user_id='$this->loginUserID'") or die (databaseConnection::showErrorMessage("Cannot open table playlists from database."));
		$selectUserPlaylist->bind_result($id, $playlistName, $userId);
		$selectUserPlaylist->execute();
		$websiteUserPlaylists = array();
		$playlists = array();

		while($selectUserPlaylist->fetch()){
			$websiteUserPlaylists['id'] = $id;
			$websiteUserPlaylists['playlistName'] = $playlistName;
			$websiteUserPlaylists['userId'] = $userId;
			$playlists[] = $websiteUserPlaylists;
		}
		return $playlists;
	}

	//selecting logged in user friends
	public function selectLoginUserFriends() {
		$selectUserFriends = $this->connect->prepare("SELECT users.id, users.username FROM users, friends WHERE users.id=friends.friend_id AND friends.user_id='$this->loginUserID'") or die (databaseConnection::showErrorMessage("Cannot open table users and friends from database."));
		$selectUserFriends->bind_result($id, $username);
		$selectUserFriends->execute();
		$loginUserFriend = array();
		$friend = array(); 

		while($selectUserFriends->fetch()){
			$loginUserFriend['id'] = $id;
			$loginUserFriend['username'] = $username;
			$friend[] = $loginUserFriend;
		}
		return $friend;
	}

	//selecting logged in user choosed playlist content
	public function selectLoginUserPlaylistContent($playlistId){
		$selectPlaylistContent = $this->connect->prepare("SELECT playlists.id, songs_in_playlist.song_url FROM playlists, songs_in_playlist WHERE playlists.id = songs_in_playlist.playlist_id AND playlists.user_id ='$this->loginUserID' AND playlists.id = '$playlistId'") or die (databaseConnection::showErrorMessage("Cannot open table playlist and songs_in_playlist from database."));
		$selectPlaylistContent->bind_result($id, $songUrl);
		$selectPlaylistContent->execute();
		$playlistSongs = array();
		$songs = array();

		while ($selectPlaylistContent->fetch()) {
			$playlistSongs['id'] = $id;
			$playlistSongs['songUrl'] = $songUrl;
			$songs[] = $playlistSongs;
		}
		return $songs;
	}

	//selecting website homepage content
	public function selectHomepageContent(){
		$websiteContent = $this->connect->prepare("SELECT * FROM w_homepage");
		$websiteContent->bind_result($id, $heading, $text, $date);
		$websiteContent->execute();
		$content = array();
		$homepageContent = array();

		while ($websiteContent->fetch()) {
			$content['id'] = $id;
			$content['heading'] = $heading;
			$content['text'] = $text;
			$content['date'] = $date;
			$homepageContent[] = $content;
		}
		return $homepageContent;
	}
	
	//selects certain song from playlist if it exists
	public function searchSongFromUserPlaylist($songUrl, $playlistId){
		$searchSongFromPlaylist = $this->connect->prepare("SELECT playlist_id FROM songs_in_playlist WHERE song_url='$songUrl' AND playlist_id='$playlistId'");
		$searchSongFromPlaylist->bind_result($playlistId);
		$searchSongFromPlaylist->execute();
		if ($searchSongFromPlaylist->fetch()) {
			$songLocation = $playlistId;
			return $songLocation;
		} else {
			return 0;
		}
	}

	//selecting playlist name that has certain song
	public function playlistName($id){
		$playlistName = $this->connect->prepare("SELECT playlist_name FROM playlists WHERE id='$id'");
		$playlistName->bind_result($name);
		$playlistName->execute();
		if ($playlistName->fetch()) {
			return $name;
		}
	}

	//searches certain song from playlists
	public function checkSong($songUrl, $playlistId){
		$check = $this->connect->prepare("SELECT playlist_id FROM songs_in_playlist WHERE song_url='$songUrl' AND playlist_id='$playlistId'");
		$check->bind_result($id);
		$check->execute();
		if ($check->fetch()) {
			return $id;
		} else { return 0; }
	}

	//selects all logged in user added "Listen later songs" max 5 songs per user
	public function userListenLaterSongs(){
		$listenlater = $this->connect->prepare("SELECT * FROM listenlater WHERE user_id='$this->loginUserID'");
		$listenlater->bind_result($id, $user_id, $song_id);
		$listenlater->execute();
		$laterSongs = array();
		$selectAllLaterSongs = array();
		while($listenlater->fetch()){
			$laterSongs['id'] = $id;
			$laterSongs['songId'] = $song_id;
			$selectAllLaterSongs[] = $laterSongs;
		}
		return $selectAllLaterSongs;
	}

	//closing database connection
	public function closeConnection () {
		$this->connect->close();
	}
	
	//if any errors, this function will display it
	public function showErrorMessage($errorMessage) {
		echo $errorMessage;
		die();
	}
}
/*last variable passed to class is logged in user id*/
$databaseData = new databaseConnection('127.0.0.1','root','','karli', $_SESSION['user']);

/*selects all users from website*/
//print_r($databaseData->selectUsers());

/*selects login user playlists*/
//print_r($databaseData->selectLoginUserPlaylists());

/*selects login user intformation*/
//print_r($databaseData->selectLoginUserInformation());

/*selects login user friends*/
//print_r($databaseData->selectLoginUserFriends());

/*selects login user songs from selected playlist*/
/*$userPlaylist = $databaseData->selectLoginUserPlaylists();
print_r($databaseData->selectLoginUserPlaylistContent($userPlaylist[0]['id'])); */

/*selects homepage content from database*/
//print_r($databaseData->selectHomepageContent());
?>