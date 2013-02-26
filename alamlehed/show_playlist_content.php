<style type="text/css">
	iframe{
		margin-right: 5px;
	}
</style>
<?php
session_start();
$user_id = $_SESSION['user'];
$playlist_id = $_POST['playlist'];
error_reporting(E_ALL ^ E_NOTICE);

	$connection = new mysqli('127.0.0.1','karli','Ametik00l','karli') or die ('Ei suutnud andmebaasiga ühendada');
  	$songs_in_playlist = $connection->prepare("SELECT playlists.id, songs_in_playlist.song_url FROM playlists, songs_in_playlist WHERE playlists.id = songs_in_playlist.playlist_id AND playlists.user_id ='$user_id' AND playlists.id = '$playlist_id'")or die("v6imatu");
  	$songs_in_playlist->bind_result($id, $song_url);
  	$songs_in_playlist->execute();
    $songs = array();
    $i=0;
    while ($songs_in_playlist->fetch()) { $songs[$i] = $song_url; $i++; }
    $songs_in_array = count($songs);
    $connection->close(); 
?>

<iframe width="640" height="360" src="http://www.youtube.com/embed/<?php echo $songs[0]; ?>?playlist=
<?php 
  for($i=1;$i<count($songs); $i++){
    if($i == $songs_in_array){
      echo $songs[$i];
    } else {
      echo $songs[$i].',';
    }
  }
?>" frameborder="0" allowfullscreen></iframe>
