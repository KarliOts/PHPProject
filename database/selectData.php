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
		$selectUser = $this->connect->prepare("SELECT * FROM kasutajad") or die (databaseConnection::showErrorMessage("Cannot open table kasutajad from database."));
		$selectUser->bind_result($id, $username, $password, $email, $firstname, $lastname);
		$selectUser->execute();
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
		$selectUser = $this->connect->prepare("SELECT * FROM kasutajad WHERE id='$this->loginUserID'") or die (databaseConnection::showErrorMessage("Cannot open table kasutajad from database."));
		$selectUser->bind_result($id, $username, $password, $email, $firstname, $lastname);
		$selectUser->execute();
		while($selectUser->fetch()){
			$websiteLoginUserInformation['id'] = $id;
			$websiteLoginUserInformation['usrname'] = $username;
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
		$selectUserFriends = $this->connect->prepare("SELECT kasutajad.id, kasutajad.username FROM kasutajad, friends WHERE kasutajad.id=friends.friend_id AND friends.user_id='$this->loginUserID'") or die (databaseConnection::showErrorMessage("Cannot open table kasutajad and friends from database."));
		$selectUserFriends->bind_result($id, $username);
		$selectUserFriends->execute();
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
		while ($websiteContent->fetch()) {
			$content['id'] = $id;
			$content['heading'] = $heading;
			$content['text'] = $text;
			$content['date'] = $date;
			$homepageContent[] = $content;
		}
		return $homepageContent;
	}
	//searching from youtube
	public function searchFromYoutube($searchKeyWord){
		$searchedKeyWord = preg_replace("/ /", "//+/", $searchKeyWord);
		$html = file_get_contents("http://www.youtube.com/results?search_query=$searchedKeyWord");
		$videoTitle = explode('<div class="yt-lockup2-thumbnail">', $html);
		
		for($j = 1; $j < 19; $j++){
			$dom = new DOMDocument();
			@$dom->loadHTML($videoTitle[$j]);
			$a = $dom->getElementsByTagName('a');
			$vimg = $dom->getElementsByTagName('img');
			
				$title = array();
				$attr = array();
				$img = array();
				$img2 = array();
			
			for ($i=0; $i < $a->length; $i++) {
				$attr[] = $a->item($i)->getAttribute('href'); 
				$title[] = $a->item($i)->textContent;
			}
			for ($i=0; $i < $vimg->length; $i++) {
				$img[] = $vimg->item($i)->getAttribute('src');
			}
			for ($l=0; $l < $vimg->length; $l++) {
				$img2[] = $vimg->item($l)->getAttribute('data-thumb'); 
			}

			if(empty($attr[1]) || empty($title[1])){ 
				echo "";
			} else {
				$Stitle = explode(' ', $title[1]);
				$substr = "";
				foreach ($Stitle  as $current) {
					if (strlen($substr) >= 65) { break; }
			    	$substr .= $current . ' ';
				}
				$location = explode("=",$attr[1]);
				
				if(!empty($location[1])){
					$songInformation['name'] = $substr;
					$songInformation['url'] = $location[1];
					$songInformation['img'] = $img[0];
					$songInformation['img2'] = $img2[0];
					$searchedSongInformation[] = $songInformation; 
				}			
			}
		}
		return $searchedSongInformation;
	}
	//if any errors, this function will display it
	public function showErrorMessage($errorMessage) {
		echo $errorMessage;
		die();
	}
}
/*number 1, the last variable passed to class is logged in user id*/
$databaseData = new databaseConnection('127.0.0.1','karli','Ametik00l','karli','1');

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