<!doctype html>
<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" />
    <title>Youtube music player</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.js"></script>
  </head>
  <body>
  
    <div class="navbar navbar-fixed-top ">
      <div class="navbar-inner">
        <div class="container">
          <a href="index.php" class="brand">Youtube music player</a>
            <ul class="nav pull-right">
              <li class="active"><a href="#">Avaleht</a></li>
            </ul>
        </div>
      </div>
    </div>
    
    <div class="hero-unit">
      <h3>Youtube playlist maker</h3>
      <p>Otsi, kuula ja jaga parimat muusikat oma sõpradega</p>
      <a href="#">Tutvu</a>
    </div>
      
    <div class="span8 well videoList">
      <form id="searchEngine">
        <input type="text" class="input-large span8 keyword" placeholder="Otsi... (ENTER)">
      </form>
       
        <div class="videoListVodeos">
          <!--All videos come here listed-->
        </div>
    </div>
    <div class="span5 videoFrame well"></div>
    
  </body>
</html>