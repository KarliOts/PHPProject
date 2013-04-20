$(document).ready(function(){
	//hiding login and register error message div elements
	$('.loginmessage').hide();
	$('.registermessage').hide();

		/*DEALING WITH USER NOTIFICATIONS INCLUDING FRIENDS*/
			//accepting friend requests
			$('.kinnita').click(function(){
				friendId = $(this).val();
				$.post('database/updateData.php', {friendId: friendId, notify: 'accept'}, function(data){
					window.location.reload();
				});
			});

			//listening reccommended music
			$('.kuula').click(function(){
				songUrl = $(this).val();
                                songName = $('.songName').text();
                                $('#notifications').modal('show');
				$.post('subPages/youtubeVid.php', {songUrl: songUrl, songName: songName}, function(data){
					$('.music_notify').html(data);
				});
			});
                            //clearing modal after closing it
                            $('.close').click(function(){
                                $('.music_notify').html('');
                            });
                        
			//removing recocommended song from database
			$('.eemalda').click(function(){
				songId = $(this).val();
				$.post('database/updateData.php', {songId: songId, notify: 'removeSong'}, function(data){
					window.location.reload();
				});
			});

	//profiili lehel input-ide tooltip
	$('.triggerPopover').tooltip({'trigger':'focus', 'placement': 'right'});
        
        //adding friend to logged in user
        $('.lisa_s6braks').click(function(){
            friendId = $(this).val();
            $(this).text('lisatud').attr('disabled','disabled');
            $.post('database/insertData.php', {friendId : friendId, choice: 'friend'});
        });
        
        //removing friend from friends list
        $('.eemalda_s6ber').click(function(){
            friendId = $(this).val();
            $(this).text('eemaldatud :( :( ').attr('disabled','disabled');
            $.post('database/updateData.php', {friendId : friendId, choice: 'unfriend'}, function(data){
                window.location.reload();
            });
        });
        
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
	
	/*youtubest otsitud laulu peale vajutades saadav laulu urli teisele lehele ja tagastab iframe koos youtube embed videoga millel on
	autoplay võrdne 1-ga, mis tähendab seda, et laul hakkab automaatselt mängima*/
	$('.videoLink').click(function(){
		vidLink = $(this).val();
                songName = $('.songName', this).text();
		$.post('subPages/youtubeVid.php', {songUrl: vidLink, songName: songName}, function(video){
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
	

	//peamenüü navigatsioon
	$('.headMenu').click(function(){
		headPage = $(this).attr('href');
		if(headPage == 'lahku'){ 
			$('.content').load('subPages/'+ headPage +'.php');
			window.location.reload();
		}
		return false;
	});
});