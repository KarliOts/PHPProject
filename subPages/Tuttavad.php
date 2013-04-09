<script type="text/javascript" src="js/jquery.js"></script>
<?php
	error_reporting(E_ALL ^ E_NOTICE);
	session_start();
	include_once 'database/selectData.php';
	$countFriends = count($databaseData->selectLoginUserFriends());
	$j=1;
	echo "<div class='span5 well'>
		<h5>Minu tuttavad</h5>
    		<table class='table table-striped table-condensed'>
    		<tr><td><b>#</b></td><td><b>Kasutaja</b></td><td><b>Kustuta</b></td></tr>";
    		
    		for ($i=0; $i < $countFriends; $i++) { 
    			echo '<tr><td>'.$j.'</td><td>'.$databaseData->selectLoginUserFriends()[$i]['username'].'</td><td><a href="'.$databaseData->selectLoginUserFriends()[$i]['id'].'" class="btn btn-small btn-danger">Eemalda</a></td></tr>';
    			$j++;
    		}
    		
	echo "</table></div>";
	
	echo "<div class='span5 well'>
		<h5>Otsi tuttavaid (kasutajanime järgi)</h5><input type='text' id='tuttavaNimi' placeholder='Sisestage nimi siia' />
		<div class='otsiTuttavad'>

		</div>
	</div>";
?>