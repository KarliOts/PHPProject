<script type="text/javascript" src="js/jquery.js"></script>
<?php
	error_reporting(E_ALL ^ E_NOTICE);
	session_start();
	include_once 'database/selectData.php';

	echo '<div class="well span2">';
	for ($i=0; $i < count($databaseData->selectLoginUserPlaylists()); $i++) { 	
		echo "<a class='playlistName' href='".$databaseData->selectLoginUserPlaylists()[$i]['id']."'>";
			echo $databaseData->selectLoginUserPlaylists()[$i]['playlistName'];
		echo "</a><br />";
	}
	echo '</div><div class="span7 well playlist"></div>';
?>