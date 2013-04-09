<?php
	session_start();
	error_reporting(E_ALL ^ E_NOTICE);
	include_once '/database/selectData.php';
	
	//getting youtube video title
	for ($i=0; $i<5; $i++){ 
		$videoTitle[$i] = $databaseData->userListenLaterSongs()[$i]['songId'];
		$yUrl = $databaseData->userListenLaterSongs()[$i]['songId'];
		$sId = $databaseData->userListenLaterSongs()[$i]['id'];

		$url = "http://gdata.youtube.com/feeds/api/videos/". $videoTitle[$i];
    	$doc = new DOMDocument;
    	$doc->load($url);
    	$title = $doc->getElementsByTagName("title")->item(0)->nodeValue;
    	
    	$titles[$i]['id'] = $sId;
    	$titles[$i]['yUrl'] = $yUrl;
    	$titles[$i]['title'] = $title;
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