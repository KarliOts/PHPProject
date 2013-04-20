<?php
	session_start();
	error_reporting(E_ALL ^ E_NOTICE);
	include_once '/database/selectData.php';
        include_once '/database/countData.php';
	
	//getting youtube video title
        //counting videos
        $songs = $countUserData->countUserListenLaterSongs();
	for ($i=0; $i< $songs; $i++){ 
            $titles[$i]['id'] = $databaseData->userListenLaterSongs()[$i]['id'];
            $titles[$i]['yUrl'] = $databaseData->userListenLaterSongs()[$i]['songUrl'];
            $titles[$i]['title'] = $databaseData->userListenLaterSongs()[$i]['songName'];
	}
	echo '
		<table class=" well table table-hover table-condensed table-striped span9">
		<tr><td><b>Laulu pealkiri</b></td><td><b>########</b></td></tr>
	';
	
	//printing out video titles
	foreach ($titles as $songTitle) {
		echo '<tr>
			<td>'.$songTitle["title"].'</td>
			<td>
				<div class="dropdown">
				  <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"> Valik <span class="caret"></span></button>
				  <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
				    <li><a tabindex="-1" href="index.php?leht=hiljem&vaata='.$songTitle['yUrl'].'">Vaata</a></li>
				    <li><a tabindex="-1" href="index.php?leht=hiljem&kustuta='.$songTitle['id'].'">Kustuta</a></li>
				    <li class="divider"></li>
				    <li><a tabindex="-1" href="index.php?leht=hiljem&lisa='.$songTitle['yUrl'].'">Lisa playlisti</a></li>
				  </ul>
				</div>
			</td>
		</tr>';
	}

	echo '</table>';
?>