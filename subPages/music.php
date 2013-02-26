<style type="text/css"> img{ width: 20%; } .vids{ margin-left: -30px; } </style>
<script src="js/jquery.js"></script>
<?php
if(isset($_POST['search'])){
	include('../database/selectData.php');
	$songsFound = $databaseData->searchFromYoutube($_POST['search']);
	$number = count($databaseData->searchFromYoutube($_POST['search']));
	echo '<div class="span6 vids">';
	for($i=0; $i<$number; $i++){
		echo '<button class="span8 btn btn-large videoLink" value="'.$songsFound[$i]['url'].'">';
		if(preg_match('/\b(mqdefault.jpg)\b/', $songsFound[$i]['img'])){
			echo '<img class="thumb pull-left" src="'.$songsFound[$i]['img'].'"></img>';
		} else {
			echo '<img class="thumb pull-left" src="'.$songsFound[$i]['img2'].'"></img>';
		}
		echo '<h6>'.$songsFound[$i]['name'].'</h6>';
		echo '</button>';
	}
	echo '</div>';
}
?>