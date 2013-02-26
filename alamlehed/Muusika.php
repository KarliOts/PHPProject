<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="../js/bootstrap.min.js"></script>
<script src="../js/logi_register.js"></script>
<script type="text/javascript">
$(document).ready(function(){
    //YOUTUBE MUUSIKAVIDEO HAKKAB M'NGIMA
    $('.kuula').live('submit', function(){
    	link = $('#link', this).val();
    	$.post('alamlehed/n2itavideot.php',{location: link}, function(v_data){
            $('.vids').html(v_data);
	});
    	return false;
    });
    //YOUTUBE SEARCH INPUT
    $('.form-search').live('submit', function(){
    	search_key_word =  $('#song_name').val();
    	$.post('alamlehed/search_engine.php', {search_key_word: search_key_word}, function(data){
    		$('.playlist').html(data);
    	});
    	return false;
    });
    //VIDEO ALUMISED NUPUD
    $('.soovita_edasi').live('click', function(){ 
        $('#choose_friend').show();
        return false;
    });
    $('.lisa_omale').live('click', function(){ 
       $('#choose_playlist').show();
        return false;
    }); 
});
</script>
<style type="text/css"> 
.kuula{
	margin: 0;
	padding: 0;
}
.vids{
    width: 380px;
    height: 340px;
}
.image{
    height: 120px;
}
.y_list{
    margin-left: 47%;
    width: auto;
    height: auto;
}
#choose_playlist{
    display: none;
}
#choose_friend{
    display: none;
}
p{
    color: #999;
}
</style>

<div class="span5 well vids"></div> 
<div class="y_list">
    <div class="span11 well"> 
    	<form class="form-search">
      		<div class="input-append">
        		<input type="text" id="song_name" class="search-query">
        		<input type="submit" id="search" class="btn" value="otsi">
    		</div>
    	</form>
    	<ul class="nav nav-list"><li class="divider"></li></ul>
    	
    	<div class="playlist">
            <p><b> Otsige muusikat otse youtubest, looge oma playlist, ning nautige.<bs></p>
        </div>
    </div> 
</div>