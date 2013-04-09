<?php
	error_reporting(E_ALL ^ E_NOTICE);
	session_start();
  include_once '../database/selectData.php';

	$songsInPlaylist = $databaseData->selectLoginUserPlaylistContent($_POST['playlistId']);
	$songsInArray = count($songsInPlaylist);
?>

<iframe width="670" height="375" src="http://www.youtube.com/embed/<?php echo $songsInPlaylist[0]['songUrl']; ?>?playlist=
<?php 
  for($i=1;$i<count($songsInPlaylist); $i++){
    if($i == $songsInArray){
      echo $songsInPlaylist[$i]['songUrl'];
    } else {
      echo $songsInPlaylist[$i]['songUrl'].',';
    }
  }
?>" frameborder="0" allowfullscreen>