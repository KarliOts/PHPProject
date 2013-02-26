<?php
    session_start();
    $user_id = $_SESSION['user'];
    $connection = new mysqli('127.0.0.1','karli','Ametik00l','karli') or die ('Ei suutnud andmebaasiga ühendada');
    $handle = $connection->prepare("SELECT id, playlist_name FROM playlists WHERE user_id='$user_id'")or die("v6imatu");
    $handle->bind_result($id, $playlist_name);
    $handle->execute();
    while ($handle->fetch()) {
      echo '<a href="'.$id.'" >'.$playlist_name.'</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
      echo '<button class="btn btn-mini class="muuda" href="'.$id.'" >Muuda</button><br/>';
    }
    $connection->close();
?>
