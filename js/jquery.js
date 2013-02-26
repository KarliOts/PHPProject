$(document).ready(function(){ 
	$("li").click(function(){
		$("li").removeClass("active");
		$(this).addClass("active"); 
		return false;
	});
	$('#searchEngine').live('submit', function(){
		search = $('.keyword').val();
		$.post('subPages/music.php', {search: search}, function(videoList){
			$('.videoListVodeos').html(videoList);
		});
		return false;
	});
	$('.videoLink').click(function(){
		vidLink = $(this).val();
		$('.videoFrame').html('<iframe width="100%" height="300" src="http://www.youtube.com/embed/'+vidLink+'?autoplay=1" frameborder="0" allowfullscreen ></iframe>');
	});
});