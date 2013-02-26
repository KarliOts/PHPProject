<div class="span2"></div>
<div class="span7">
	<div class="span12"></div>
<?php
	error_reporting(E_ALL ^ E_NOTICE);
	session_start();
	$user_id = $_SESSION['user'];
	$connection = new mysqli('127.0.0.1','karli','Ametik00l','karli') or die ('Ei suutnud andmebaasiga ühendada');
	$notification = $connection->prepare("SELECT recommendations.id, recommendations.recommendation, recommendations.done_or_not, kasutajad.username, kasutajad.firstname, kasutajad.lastname FROM recommendations, kasutajad WHERE recommendations.friend_id='$user_id' AND kasutajad.id=recommendations.user_id");
	$notification->bind_result($id, $recommendation, $done_or_not, $username, $firstname, $lastname);
	$notification->execute();
	while($notification->fetch()){
		if($done_or_not == 0){
			if ($recommendation == 'FRIEND') {
				echo "<div class='span11 well'>";
					echo "Kasutaja: <b>". $firstname.' '.$lastname.'</b> soovib olla teie s6ber <br/>';
					echo "<button class='btn btn-small' value='".$id."'>Kinnita</button>";
				echo "</div>";
			} else {
				echo "<div class='span11 well'>";
					$video_url = explode(':', $recommendation);
					echo "Kasutaja: <b>". $username .'</b> soovitas teile <br/>';
					echo '<iframe width="200" height="150" src="http://www.youtube.com/embed/'.$video_url[1].'?autoplay=0" frameborder="0" allowfullscreen ></iframe></br>';
					echo "<button class='btn btn-small' value='".$id."'>Märgi loetuks</button>";
				echo "</div>";
			} 
		}
	}
?>
</div>
<div class="span2"></div>