<style type="text/css"> img{ width: 100px; height: 100px; } </style>
<?php
	error_reporting(E_ALL ^ E_NOTICE);
	session_start();
	include_once 'database/selectData.php';
	$countFriends = count($databaseData->selectLoginUserFriends());
	echo "<div class='span5 well'>
		<h5>Minu tuttavad</h5>";
    		//printing out all logged in user friends
    		for ($i=0; $i < $countFriends; $i++) {
                    $id = $databaseData->selectLoginUserFriends()[$i]['id'];
                    $username = $databaseData->selectLoginUserFriends()[$i]['username'];
                    
                    echo '<div class="kasutaja span5" style="margin-bottom:5px; margin-left:0">';
                            if (file_exists("profileImages/".$username.'.jpg')) {
                                    echo '<img src="profileImages/'.$username.'.jpg" class="img-polaroid pull-left" >';
                            } else {
                                    echo '<img src="profileImages/anonymous.jpg" class="img-polaroid pull-left" >';
                            }
                            echo '<h4 style="margin-left:120px"><small>Kasutajanimi: <b>'.$username.'</b></small></h4>';
                            echo '<button style="margin-left:10px" class="eemalda_s6ber btn btn-small pull-left" value="'.$id.'">Eemalda :( </button>';
                        echo "</div>";
    		}
    		
	echo "</div>";
	echo '<div class="span5 well">
		<h5>Otsi tuttavaid (kasutajanime järgi)</h5>
                    <form method="get" action="'.$_SERVER['PHP_SELF'].'" class="form-search">
                        <div class="input-append">
                            <input type="hidden" name="leht" value="tuttavad">
                            <input type="text" class="span2 search-query" name="kasutaja" placeholder="Otsi... (ENTER)">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>
                <div class="otsiTuttavad">';
        
                if (isset($_REQUEST['kasutaja'])) {
                    if ($_REQUEST['kasutaja'] != '') {
                        $userId = $_SESSION['user'];
                        $nimi = $_REQUEST['kasutaja'];
                        $connection = new mysqli('127.0.0.1','root','','karli') or die ('Ei suutnud andmebaasiga ühendada');
                        $connection->query('SET NAMES utf8');
                        $search = $connection->prepare("SELECT DISTINCT users.id, users.username, users.firstname, users.lastname FROM users WHERE users.id NOT IN( SELECT friends.friend_id FROM friends WHERE friends.user_id='$userId' ) AND users.username LIKE '%$nimi%'");
                        $search->bind_result($id, $username, $firstname, $lastname);
                        $search->execute();
	
                        while($search->fetch()){
                            echo '<div class="kasutaja span5" style="margin-bottom:5px; margin-left:0">';
                                if (file_exists("profileImages/".$username.'.jpg')) {
                                    echo '<img src="profileImages/'.$username.'.jpg" class="img-polaroid pull-left" >';
                                } else {
                                    echo '<img src="profileImages/anonymous.jpg" class="img-polaroid pull-left" >';
                                }
                                echo '<h4 style="margin-left:120px"><small>Kasutajanimi: <b>'.$username.'</b></small></h4>';
                                echo '<h4 style="margin-left:120px"><small>Ees ja perenimi: : <b>'.$firstname.' '.$lastname.'</b></small></h4>';
                                echo '<button style="margin-left:10px" class="lisa_s6braks btn btn-small pull-left" value="'.$id.'">Lisa sõbralisti :) </button>';
                            echo "</div>";
                        } $connection->close();
                    } else {
                        echo '<div class="alert alert-danger">Palun sisestage kasutajanimi keda soovite otsida!</div>';
                    }
                     
                }
        echo "</div></div>";
?>