<?php
	error_reporting(E_ALL ^ E_NOTICE);
	session_start();

	class countUserDatabaseData {
		
		//defining variables
		private $hostname;
		private $username;
		private $password;
		private $database;
		private $loginUserId;
		private $connection;

		//building object
		function __construct($host, $user, $pass, $data, $userId) {
			$this->hostname = $host;
			$this->username = $user;
			$this->password = $pass;
			$this->database = $data;
			$this->loginUserId = $userId;
			countUserDatabaseData::buildConnection();
		}

		//building connection to database
		public function buildConnection(){
			$this->connection = new mysqli($this->hostname, $this->username, $this->password, $this->database)or die(countUserDatabaseData::error("cant build connection to database"));
			$this->connection->query('SET NAMES utf8');
		}

		//counting all user songs in certain playlist
		public function countUserSongsInPlaylists($loginUserPlaylistId){
			$countPlaylistSongs = $this->connection->prepare("SELECT playlists.id, songs_in_playlist.song_url FROM playlists, songs_in_playlist WHERE playlists.user_id='$this->loginUserId' AND playlists.id=songs_in_playlist.playlist_id AND playlists.id='$loginUserPlaylistId'");
			$countPlaylistSongs->bind_result($playlistId, $playlistSongUlr);
			$countPlaylistSongs->execute();
			while($countPlaylistSongs->fetch()){
				$countPlaylistSize['songUrl'] = $playlistId;
				$countAllPlaylistSizes[] = $countPlaylistSize;
			}
			$countedPlaylist = count($countAllPlaylistSizes);
			return $countedPlaylist;
		}
		
		//counts all user songs that user wants to listen later
		public function countUserListenLaterSongs(){
			$listenlater = $this->connection->prepare("SELECT * FROM listenlater WHERE user_id='$this->loginUserId'");
			$listenlater->bind_result($id, $user_id, $song_id);
			$listenlater->execute();
			while($listenlater->fetch()){
				$countLaterSize['id'] = $user_id;
				$countUserAllLaterVideos[] = $countLaterSize;
			}
			$countedLaterSongs = count($countUserAllLaterVideos);
			return $countedLaterSongs;
		}

		//if any errors, this function will return it
		public function error($message){
			return $message;
		}
	}

	$countUserData = new countUserDatabaseData('127.0.0.1', 'root', '', 'karli', $_SESSION['user']);
?>