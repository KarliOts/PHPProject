<?php 
  header("Location: ../index2.php");
  error_reporting(E_ALL ^ E_NOTICE);
  session_start(); ?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
    <title>Youtube music player</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/logi_register.js"></script>
    <script type="text/javascript">
    	$(document).ready(function(){
        leht = $(".active").text();
          $.post('alamlehed/valiLeht.php',{leht: leht},function(andmed){
            $('.search_input').html(andmed);
          });
          
    		$("li").click(function(){
    			$("li").removeClass("active");
    			$(this).addClass("active"); 
    			leht = $(".active").text(); 
          
          $.post('alamlehed/valiLeht.php',{leht: leht},function(andmed){
            if(andmed == "exit"){
              window.location.reload();
            } else {
              $('.search_input').html(andmed);
            }
          });
    			return false;
        });
    	});
    </script>
  </head>
  <body>

    <div class="navbar navbar-fixed-top ">
      <div class="navbar-inner">
        <div class="container">
          <a href="index.php" class="brand">Youtube music player</a>
            <ul class="nav pull-right">
              <li class="active"><a href="#">Avaleht</a></li>
              <li><a href="#">Muusika</a></li>
              <?php if($_SESSION['user'] != ''){ ?>
                <li><a href="#">Teated</a></li>
                <li><a href="#">Logi välja</a></li> 
              <?php } ?>
            </ul>
        </div>
      </div>
    </div>
     
     <?php if($_SESSION['user'] == ''){ ?>
      <div class="hero-unit">
          <h3>Youtube playlist maker</h3>
          <p>Otsi, kuula ja jaga parimat muusikat oma sõpradega</p>
          <a href="#">Tutvu</a>
      </div>
     <?php } ?>


    <div style="margin-top:50px"class="row-fluid">
      <div class="span12">
        <div class="search_input"></div>
      </div>
      <div id="push"></div>
    </div>


    <div id="footer">
      <div class="container">
        <p class="muted credit">&copy; 2013 Karli Ots</p>
      </div>
  </body>
</html>