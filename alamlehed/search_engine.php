<link href="css/bootstrap.css" rel="stylesheet">
<link href="css/bootstrap-responsive.css" rel="stylesheet"> 
<style type="text/css">
	.pilt{
		display: none;
		position: absolute;
	}
</style>
<?php
if (isset($_POST['search_key_word'])) {
	session_start();
	error_reporting(E_ALL ^ E_NOTICE);
	$search_key_word = preg_replace("/ /", "//+/", $_POST['search_key_word']);
	$html = file_get_contents("http://www.youtube.com/results?search_query=$search_key_word");
	$video_title = explode('<div class="yt-lockup2-thumbnail">', $html);
	
	for($j = 1; $j < 19; $j++){
		$dom = new DOMDocument();
		@$dom->loadHTML($video_title[$j]);
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
				if($_SESSION['user'] != ''){
					/*SISSELOGITUD KASUTAJAD KAASA ARVATUD ADMINISTRAATOR*/
					$for_control = $location[1];
					$connection = new mysqli('127.0.0.1','karli','Ametik00l','karli');
					$control = $connection->prepare("SELECT song_url FROM songs_in_playlist WHERE song_url='$for_control'");
					$control->bind_result($song_url);
					$control->execute();

					echo'<form class="kuula">
						<div class="row-fluid input-append">
						<input id="popover" type="submit" class="span9 btn btn-large" id="appendedInputButton" value="'.$substr.'">
						<input id="link" type="hidden" value="'.$location[1].'">';

						if($control->fetch()){
							echo '<input  class="btn btn-large btn-success" disabled="disabled" type="button" value="Playlistis">'; 
						} else {
							echo '<input id="lisa" class="btn btn-large" type="button" disabled="disabled" value="Pole playlistis">';
						}
						echo '</div></form>';
						
					$connection->close();
				} else {
					/*KUI KEEGI POLE SISSE LOGINUD*/
					echo'<form class="kuula">
						<div class="row-fluid input-append">
						<input type="submit" class="span12 btn btn-large" id="appendedInputButton" value="'.$substr.'">
						<input id="link" type="hidden" value="'.$location[1].'">
						</div> 
					</form>';
				}
			}
		}
	}
} else {
	echo "wrong keyword!";
}

?>