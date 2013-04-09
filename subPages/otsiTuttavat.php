<?php
	error_reporting(E_ALL ^ E_NOTICE);
	session_start();
	$userId = $_SESSION['user'];
	$nimi = $_POST['tuttavaNimi'];
	$connection = new mysqli('127.0.0.1','root','','karli') or die ('Ei suutnud andmebaasiga ühendada');
	$connection->query('SET NAMES utf8');
	$search = $connection->prepare("SELECT DISTINCT users.id, users.username, users.firstname, users.lastname FROM users WHERE users.id NOT IN( SELECT friends.friend_id FROM friends WHERE friends.user_id='$userId' ) AND users.username LIKE '%$nimi%'");
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
?>