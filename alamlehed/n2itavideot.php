<?php 
session_start();
	$video = $_POST['location']; 
	$send_or_add = 'http://www.youtube.com/watch?v='.$video;
	$user_id = $_SESSION['user'];
?>
	<iframe width="100%" height="300" src="http://www.youtube.com/embed/<?php echo $video; ?>?autoplay=1" frameborder="0" allowfullscreen ></iframe>
<?php 
if($_SESSION['user'] != ''){ ?>
<script type="text/javascript">
 $("#choose_playlist").change(function() {
    selectVal = $('#choose_playlist :selected').val();
    video_url = $('#location').val();
    $.post('alamlehed/add_to_playlist.php', {selectVal: selectVal, video_url: video_url}, function(succ_data){
    	alert('Lisatud');
    	$('#choose_playlist').hide();
    });
});
    $("#choose_friend").change(function() {
    friend = $('#choose_friend :selected').val();
    f_video_url = $('#location').val();
    $.post('alamlehed/add_to_playlist.php', {friend: friend, video_url: f_video_url}, function(succ_data){
    	alert(succ_data);
    	$('#choose_friend').hide();
    });
});
</script>
<form class="kasutaja_valik">
	<div class="row-fluid input-append">
		<button class="btn btn-large soovita_edasi" value="<?php echo $video; ?>">Soovita</button>
		<button class="btn btn-large lisa_omale" value="<?php echo $video; ?>">Lisa playlisti</button>
		<select id="choose_playlist">
			<option value=''></option>
				<?php
					$connection = new mysqli('127.0.0.1','karli','Ametik00l','karli') or die (error_message('Ei suutnud andmebaasiga ühendada'));
					$choose = $connection->prepare("SELECT id, playlist_name FROM playlists WHERE user_id='$user_id'");
					$choose->bind_result($id, $playlist_name);
					$choose->execute();
					while($choose->fetch()){
						echo '<option value="'.$id.'">'.$playlist_name.'</option>';
					}
				?>
			</select> 

			<select id="choose_friend">
			<option value=''></option>
				<?php
					$connection = new mysqli('127.0.0.1','karli','Ametik00l','karli') or die (error_message('Ei suutnud andmebaasiga ühendada'));
					$choose = $connection->prepare("SELECT kasutajad.id, kasutajad.username FROM kasutajad, friends WHERE friends.friend_id=kasutajad.id AND friends.user_id='$user_id'");
					$choose->bind_result($id, $username);
					$choose->execute();
					while($choose->fetch()){
						echo '<option value="'.$id.'">'.$username.'</option>';
					}
				?>
			</select>

		<input type="hidden" id="location" value="<?php echo $video; ?>">
	</div>
</div>
<?php }?>