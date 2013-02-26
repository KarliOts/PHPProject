<?php session_start(); error_reporting(E_ALL ^ E_NOTICE); ?>
<script type="text/javascript">
  $(document).ready(function(){
    $('.playlist_nr').html("<h1>Valige vasakult playlist</h1>");

    $('.playlist').click(function(){
      var playlist = $('a', this).attr("href");
      $('i').removeClass('icon-play');
      $('i', this).addClass('icon-play');
        $.post('alamlehed/show_playlist_content.php', {playlist: playlist}, function(data){
          $('.playlist_nr').html(data); 
        });
        return false;
      });
  $('.save_playlist').click(function(){
    playlist_name = $('.playlist_name').val();
  });

  $('.vaata').click(function(){
    $('.friends_modal').load('alamlehed/friends_modal.php');
  });

  $('.lisa').click(function(){
    $('.add_friends').load('alamlehed/add_friends.php');
  });
  
  $('.halda').click(function(){
      $('.playlist_modal').load('alamlehed/playlist_modal.php');
  });

});
</script>
<style type="text/css">
.playlist_nr{
  height: auto;
  width: auto;
  overflow: auto;
}
h1{
  margin: 0;
  padding: 0;
  color: #DDD;
}
.playlist_input{
  display: none;
  height: 8px;
}
.playlist_name{
  margin-top: 10px;
}
</style>
<div class="span3 user_menu well">
  <ul class=" nav nav-list">
    <span id="notification" class="badge badge-success"></span>
    <li class="nav-header">Playlistid</li>
<?php
  $user_id = $_SESSION['user'];
  $i = 0;
  $connection = new mysqli('127.0.0.1','karli','Ametik00l','karli') or die ('Ei suutnud andmebaasiga ühendada');
  $user_playlists = $connection->prepare("SELECT id, playlist_name FROM playlists WHERE user_id='$user_id'")or die("v6imatu");
  $user_playlists->bind_result($id, $playlist_name);
  $user_playlists->execute();
  while($user_playlists->fetch()){
    echo '<li class="playlist" ><a href="'.$id.'" >'.$playlist_name.'<i></i></a></li>';
    $i++;
  }
  $connection->close();
?><br/>
    <a href="#modal" class="halda" data-toggle="modal"><small>Halda..</small></a> 
  <li class="divider"></li>

    <li class="nav-header">Sõbrad</li>
    <li><a href="#friends_modal" class="vaata" data-toggle="modal" href="#">Vaata</a></li>
    <li><a href="#friends_add_modal" class="lisa" data-toggle="modal" href="#">Lisa</a></li>
  <li class="divider"></li>

    <li class="nav-header">Konto seaded</li>
    <li><a href="#">Konto seaded</a></li>
  <li class="divider"></li>

    <li class="nav-header">Küsimused</li>
    <li><a href="#">Kontakteeru</a></li>
  </ul>
</div>
<div class="span8 playlist_nr well"></div>
<!--Playlistide haldus-->
<div id="modal" class="modal hide fade" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Halda playliste</h3>
  </div>
  <div class=" playlist_modal modal-body">
      
  </div>

  <div class="modal-footer">
    <a href="#" class="btn btn-danger" data-dismiss="modal" >Katkesta</a>
    <a href="#" class="btn btn-success save_playlist" data-dismiss="modal" >Salvesta</a>
  </div></div>
<!--s6prade eemaldamine-->
<div id="friends_modal" class="modal hide fade" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Sõbralist</h3>
  </div>

  <div class=" friends_modal modal-body">

  </div>

  <div class="modal-footer"> 
    <p class='p'></p>
    <a href="#" class="btn btn-danger" data-dismiss="modal" >Katkesta</a>
    <a href="#" class="btn btn-success save_playlist" data-dismiss="modal" >Salvesta</a>
  </div></div>
<!--s6prade lisamine-->
<div id="friends_add_modal" class="modal hide fade" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>Lisa tuttavaid</h3>
  </div>
  <div class="add_friends modal-body"></div>

  <div class="modal-footer">
    <a href="#" class="btn btn-danger" data-dismiss="modal" >Katkesta</a>
    <a href="#" class="btn btn-success save_playlist" data-dismiss="modal" >Salvesta</a>
  </div></div>