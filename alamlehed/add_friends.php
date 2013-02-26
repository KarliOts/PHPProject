<input type="text" placeholder="Otsi..." class="search_friend span5" />
<script type="text/javascript">
	$('.search_friend').keyup(function(e){
		friends_name = $(this).val();
		$.post('alamlehed/delete_from_database.php', {choose: 'add_friend', friends_name: friends_name}, function(data){
	    	$('.data').html(data);
	    });
	});
</script>
<div class="data"></div>