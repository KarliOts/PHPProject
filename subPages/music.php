<style type="text/css"> img{ width: 20%; } .vids{ margin-left: -6px; } #image{ display: none; } img{ display: none; } .searchedFromYoutube{ height: 60px;}</style>
<?php
error_reporting(E_ALL^E_NOTICE);
session_start();
include_once '/database/selectData.php';

if(isset($_POST['search'])){

	$searchKeyWord = $_POST['search'];
	session_start();
	error_reporting(E_ALL^E_NOTICE);
		$searchedKeyWord = preg_replace("/ /", "//+/", $searchKeyWord);
		$html = file_get_contents("http://www.youtube.com/results?search_query=$searchedKeyWord");
		$videoTitle = explode('<div class="yt-lockup2-thumbnail">', $html);
		echo '<div class="span5 vids">';
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
					for ($i=0; $i<3; $i++) {
						$playlistId[$i] = $databaseData->selectLoginUserPlaylists()[$i]['id'];
						$playlistNr = $databaseData->searchSongFromUserPlaylist($location[1], $playlistId[$i]);
						if ($playlistNr != 0) {
							$truePlaylistName[] = $databaseData->playlistName($playlistNr);
							$checked = 'btn-info';
						}
					}

					echo '
						<div class="input-append input-pretend">
							<button class="btn span5 searchedFromYoutube '.$checked.' vids videoLink" value="'.$location[1].'">
								<p><h6 class="songName"> '.$substr.' </h6></p><p><small>';
									for ($i=0; $i<count($truePlaylistName);$i++){
										echo ' '.$truePlaylistName[$i];
									}
								echo '</small></p></button>
						</div>
					';
					//clearing all arrays after showing one video
					$playlistId = array();
					$playlistNr = array();
					$truePlaylistName = array();
					$checked = '';
				}			
			}
		}
		echo "</div>";
	}

/*echo '<a class="span5 btn vids videoLink disabled" value="'.$location[1].'">';
	if (preg_match('/\b(mqdefault.jpg)\b/', $img[0])) {
		//echo '<img class="thumb pull-left" src="'.$img[0].'"></img>';
	} else {
		//echo '<img class="thumb pull-left" src="'.$img2[0].'"></img>';
	}
echo '<h6 class="pull-left">'.$substr.'</h6>';
echo '</a>';*/

?>