<script type="text/javascript">
//shows playlist adding buttons
    $('.showPlaylists').hide();
    $('.addToPlaylist').click(function(){
	$('.showPlaylists').show();
    });
//soovitab laulu tuttavale
    $('.recommend').click(function(){
	videoUrl = $(this).val();
	$.post('database/insertData.php', {choice: 'recommend', videoUrl: videoUrl}, function(success){
		alert(success);
	});

    });
//lisab laulu hiljem kuulatavate laulude list
    $('.listenLater').click(function(){
	videoUrl = $(this).val();
	$.post('database/insertData.php', {choice: 'later', videoUrl: videoUrl}, function(success){
		$('.listenLater').attr('disabled', 'disabled');
	});
    });
</script> 
<?php
	//including useful classes and scripts
	include_once '../database/selectData.php';
	include_once '../database/countData.php';
	
	//counting if later listen songs playlist is full, max 5 songs
	if ($countUserData->countUserListenLaterSongs() < 5) {
		$Later = '';
	} else {
		$Later = 'disabled="disabled"';
	}

	//showing buttons under the video that comes from youtube
	echo '
		<iframe width="100%" height="300" src="http://www.youtube.com/embed/' . $_POST["songUrl"] . '?autoplay=1" frameborder="0" allowfullscreen ></iframe>
		<div class="input-append ">
			<span class="add-on">Menu</span>
			<button class="btn btn-primary addToPlaylist" value="'.$_POST["songUrl"].'">Lisa playlisti</button>
			<button class="btn btn-primary recommend" id="appendedInputButtons" value="'.$_POST["songUrl"].'">Soovita</button>
			<button class="btn btn-primary listenLater" '.$Later.' value="'.$_POST["songUrl"].'">Kuula hiljem</button>
		</div>
	';
	//getting logged in user playlist id-s
	$playlist[0] = $databaseData->selectLoginUserPlaylists()[0]['id'];
	$playlist[1] = $databaseData->selectLoginUserPlaylists()[1]['id'];
	$playlist[2] = $databaseData->selectLoginUserPlaylists()[2]['id'];

	//showing playlists when user clicks #addToPlaylist button
	//meanwhile checking if playlist is full
	echo '
		<div class="input-append showPlaylists">
			<span class="add-on">Playlistid</span>';
			for ($i=0; $i<3; $i++) { 
				$disabled = ''; 
				$red = '';
				$checked = '';
					if ($databaseData->checkSong($_POST["songUrl"], $playlist[$i]) == $playlist[$i]) { 
						$checked = 'badge-success'; 
						$disabled = 'disabled="disabled"'; 
					}
					if ($countUserData->countUserSongsInPlaylists($playlist[$i]) >= 30) { 
						$disabled = 'disabled="disabled"'; 
						$red = 'btn-danger'; 
					}
				echo '<button class="btn click '.$red.'" '.$disabled.' value="'.$playlist[$i].'">'
				.$databaseData->selectLoginUserPlaylists()[$i]['playlistName'].
				' <span class="badge '.$checked.'">'
				.$countUserData->countUserSongsInPlaylists($playlist[$i]).
				'</span></button>';
			}
	echo '</div>';
?>