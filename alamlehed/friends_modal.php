<script type="text/javascript">
$('.eemalda').click(function(){
  friend_id = $(this).val();
  $.post('alamlehed/delete_from_database.php', {choose: 'friend', friend_id: friend_id}, function(data){
    $('.friends_modal').load('alamlehed/friends_modal.php');
  });
});
</script>
<table class="table table-striped table-condensed">
  <tr><td><b>#</b></td><td><b>Kasutaja</b></td><td><b>#######</b></td></tr>
  <?php
  session_start();
    $user_id = $_SESSION['user'];
    $i=1;
    $connection = new mysqli('127.0.0.1','karli','Ametik00l','karli') or die ('Ei suutnud andmebaasiga ühendada');
    $friends=$connection->prepare("SELECT kasutajad.id, kasutajad.username FROM kasutajad, friends WHERE kasutajad.id=friends.friend_id AND friends.user_id='$user_id'");
    $friends->bind_result($id, $friend_username);
    $friends->execute(); 
    while($friends->fetch()){
      echo '  <tr><td>'.$i.'</td><td>'.$friend_username.'</td><td>
              <button class="eemalda btn btn-small btn-danger" value="'.$id.'">Eemalda</button></td>
      </tr>';
      $i++; 
    }
  ?>
</table> 
