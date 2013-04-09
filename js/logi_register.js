$('#sisene').live('submit', function(){
	username = $('.username').val();
	password = $('.password').val();
	
	$.post('subPages/login.php', {username: username, password: password, choose: "login"}, function(succ_fail){
		if(succ_fail == "ERROR"){
			$('.loginmessage').text("Kasutajanimi või parool valesti");
		} else {
			window.location.reload();
		};
	});
	return false; 
});
$('#register').live('submit', function(){
	r_username = $('.r_username').val();
	r_password = $('.r_password').val();
	password_control = $('.password_control').val();
	firstname = $('.firstname').val();
	lastname = $('.lastname').val();
	email = $('.email').val();
	
	
	$.post('subPages/register.php', {
		username: r_username, 
		password: r_password, 
		password_control: password_control,
		firstname: firstname,
		lastname: lastname,
		email: email,
		choose: "register"
	}, function(succ_fail){
		$('.registermessage').html(succ_fail);
	});
	return false; 
});