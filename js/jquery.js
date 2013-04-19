$(document).ready(function(){
	//hiding login and register error message div elements
	$('.loginmessage').hide();
	$('.registermessage').hide();

		/*DEALING WITH USER NOTIFICATIONS INCLUDING FRIENDS*/
			//accepting friend requests
			$('.kinnita').click(function(){
				friendId = $(this).val();
				$.post('database/updateData.php', {friendId: friendId, notify: 'accept'}, function(data){
					alert(data);
				});
			});

			//listening reccommended music
			$('.kuula').click(function(){
				songUrl = $(this).val();
                                $('#notifications').modal('show');
				$.post('subPages/youtubeVid.php', {songUrl: songUrl}, function(data){
					$('.music_notify').html(data);
				});
			});
                            //clearing mdal after closing it
                            $('.close').click(function(){
                                $('.music_notify').html('');
                            });
			//removing recocommended song from database
			$('.eemalda').click(function(){
				songUrl = $(this).val();
				/*$.post('database/youtubeVid.php', {songUrl: songUrl}, function(data){
					alert(data);
				});*/
			});

	//profiili lehel input-ide tooltip
	$('.triggerPopover').tooltip({'trigger':'focus', 'placement': 'right'});

	//profiili lehe formi andmete uuendamine
	$('#update').click(function(){
		$('.updateError').hide();
		$('.updateSuccess').hide();
		updateUsername = $('#updateUsername').val();
		updateEmail = $('#updateEmail').val();
		updateFirstname = $('#updateFirstname').val();
		updateLastname = $('#updateLastname').val();
			$.post('database/updateData.php', {
				updateUsername: updateUsername, 
				updateFirstname: updateFirstname, 
				updateLastname: updateLastname, 
				updateEmail: updateEmail
			}, function(data){
				if (data.length > 0) {
					$('.updateError').html(data).show();
				} else {
					$('.updateSuccess').show();
				}
			});
		return false;
	});

	//adding class named active to link that-s active right now
	praeguneLeht = $(location).attr('href');
	asukoht = praeguneLeht.split('=');
	$('.' + asukoht[1]).addClass('active');
	
	/*youtubest otsitud laulu peale vajutades saadav laulu urli teisele lehele ja tagastab iframe koos youtube embed videoga millel on
	autoplay võrdne 1-ga, mis tähendab seda, et laul hakkab automaatselt mängima*/
	$('.videoLink').click(function(){
		vidLink = $(this).val();
		$.post('subPages/youtubeVid.php', {songUrl: vidLink}, function(video){
			$('.videoFrame').html(video);
		});
		return false;
	});

	//toggle ehk siis nvajadused näitab kasutajale registreerimis vormi!
	$('.toggle-register').click(function(){
		$('.register').show().fadeIn('slow');
		return false;
	});

	//alamamenüü a href-i peale vajutades ei teeks midagi
	$('.divider').click(function(){ return false; });

	//playlisti nime peale vajutades tagastab seal olevad laulud div class playlist elementi
	$('.playlistName').click(function(){
		playlistId = $(this).attr('href');
		$.post('subPages/playlistLaulud.php', {playlistId: playlistId}, function(songs){
			$('.playlist').html(songs);
		});
		return false;
	});

	//otsib andmebaasist nupuvajutuse peale kasutajaid ja uuendab tabelit reaalajas
	$('#tuttavaNimi').keyup(function(e) {
		tuttavaNimi = $('#tuttavaNimi').val();
		$.post('subPages/otsiTuttavat.php', {tuttavaNimi: tuttavaNimi}, function(nimed){
			$('.otsiTuttavad').html(nimed);
		});
	});

	//peamenüü navigatsioon
	$('.headMenu').click(function(){
		headPage = $(this).attr('href');
		if(headPage == 'lahku'){ 
			$('.content').load('subPages/'+ headPage +'.php');
			window.location.reload();
		}
		return false;
	});
	
	//shows playlist adding buttons
	$('.addToPlaylist').click(function(){
		$('.showPlaylists').show();
	});
	
	//soovitab laulu tuttavale
	$('.recommend').click(function(){
		videoUrl = $(this).val();
		$.post('database/insertData.php', {choice: 'recommend', videoUrl: videoUrl}, function(success){
			alert(success);
		});

	});

	//lisab laulu hiljem kuulatavate laulude list
	$('.listenLater').click(function(){
		videoUrl = $(this).val();
		$.post('database/insertData.php', {choice: 'later', videoUrl: videoUrl}, function(success){
			$('.listenLater').attr('disabled', 'disabled');
		});
	});

	//hides playlist name buttons
	$('.showPlaylists').hide();

	//selecting playlist where song is going to added
	$('.click').click(function(){
		videoUrl = $('.addToPlaylist').val();
		playlistId = $(this).val();
		$.post('database/insertData.php', {choice: 'playlist', videoUrl: videoUrl, playlistId: playlistId}, function(success){
			$('.showPlaylists').hide();
		});
	});
});