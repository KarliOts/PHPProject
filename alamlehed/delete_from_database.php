<script type="text/javascript">
$('.lisa_s6braks').click(function(){
  friend_id = $(this).val();
  $.post('alamlehed/delete_from_database.php', {choose: 'add_click_friend', friend_id: friend_id}, function(data){
    $('.friends_modal').load('alamlehed/friends_modal.php');
    alert('lisatud');
  });
});
</script>
<?php session_start();
	if ($_POST['choose'] == 'friend') {
            
		$user_id = $_SESSION['user'];
		$friend_id = $_POST['friend_id'];
		$connection = new mysqli('127.0.0.1','karli','Ametik00l','karli') or die ('Ei suutnud andmebaasiga ühendada');
	    $delete = $connection->prepare("DELETE FROM friends WHERE user_id='$user_id' AND friend_id='$friend_id'")or die("v6imatu");
	    $delete->execute();
	    $connection->close();
            
	} else if ($_POST['choose'] == 'add_friend'){
            
		$keyword = $_POST['friends_name'];
		$connection = new mysqli('127.0.0.1','karli','Ametik00l','karli') or die ('Ei suutnud andmebaasiga ühendada');
		$search = $connection->prepare("SELECT id, username, firstname, lastname FROM kasutajad WHERE username LIKE '%$keyword%' OR firstname LIKE '%$keyword%' OR lastname LIKE '%$keyword%'");
		$search->bind_result($id, $username, $firstname, $lastname);
		$search->execute();
		?>
		<table class="table table-striped table-condensed">
  			<tr><td><b>#</b></td><td><b>Kasutajanimi</b></td><td><b>Eesnimi</b></td><td><b>Perenimi</b></td><td><b>#######</b></td></tr>
		<?php
		$i=1;
		while($search->fetch()){
			echo '<tr><td>'.$i.'</td><td>'.$username.'</td><td>'.$firstname.'</td><td>'.$lastname.'</td>
			<td><button class="lisa_s6braks btn btn-small btn-success" value="'.$id.'">Lisa</button></td></tr>';
			$i++;
		}
		echo '</table>';
		$connection->close();
                
	} else if ($_POST['choose'] == 'add_click_friend'){
            
		$user_id = $_SESSION['user'];
		$friend_id = $_POST['friend_id'];
		$connection = new mysqli('127.0.0.1','karli','Ametik00l','karli') or die ('Ei suutnud andmebaasiga �hendada');
		$add_friend = $connection->prepare("INSERT INTO friends (user_id,friend_id)VALUES('$user_id','$friend_id')");
		$add_friend->execute();
		$send_notification = $connection->prepare("INSERT INTO recommendations (user_id, recommendation, friend_id, done_or_not)VALUES('$user_id','FRIEND','$friend_id','0')");
		$send_notification->execute();
		$connection->close();
                
	} else if(isset($_POST['video_url'])){
		echo 'tere';
	}
?>