<?php
  session_start();
  error_reporting(E_ALL ^ E_NOTICE);
  include('database/selectData.php');
  include('database/countData.php');
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Youtube music player</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.js"></script>
    <script src="js/logi_register.js"></script>
    <style type="text/css"> .navbarTwo{ margin-top: 40px; } .terveSisu{ margin-top: 50px; }</style>
  </head>
  <body>
  
    <div class="navbar navbar-fixed-top ">
      <div class="navbar-inner">
        <div class="container">
          <a href="index.php" class="brand">Youtube music player</a>
            <ul class="nav pull-right">
              <li class="headerMenu"><a class="headMenu" href="avaleht">Avaleht</a></li>
              <?php if($_SESSION['user'] == '') { ?>
                <li class="headerMenu"><a class="headMenu" href="sisene">Sisene</a></li>
              <?php } else { ?>
                <li class="headerMenu"><a class="headMenu" href="lahku">Lahku</a></li>
              <?php } ?>
            </ul>
        </div>
      </div>
    </div>

    <?php if($_SESSION['user'] != '') { ?>

      <div class="navbar navbarTwo">
        <div class="navbar-inner">
          <div class="container">
            <ul class="nav">
              <li class="playlistid"><a href="index.php?leht=playlistid" target="_self">Playlistid</a></li>
              <li class="tuttavad" ><a href="index.php?leht=tuttavad" target="_self">Tuttavad</a></li>
              <li class="teadaanded" ><a href="index.php?leht=teadaanded" target="_self">Teadaanded</a></li>
              <li class="hiljem" ><a href="index.php?leht=hiljem" target="_self">Kuula hiljem</a></li>
              <li class="profiil" >
                <a href="index.php?leht=profiil">
                  <?=$databaseData->selectLoginUserInformation()['firstname']; ?>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    <?php } ?>
    
      <div class="span12 content">
        <?php
          if ($_SESSION['user'] != '') {
            switch ($_GET['leht']) {
              case 'playlistid':
                  include('subPages/Playlistid.php');
                break;
              case 'tuttavad':
                  include('subPages/Tuttavad.php');
                break;
              
              case 'teadaanded':
                  include('subPages/Teadaanded.php');
                break;
              
              case 'profiil':
                  include('subPages/Profiil.php');
                break;
              
              case 'hiljem':
                  include('subPages/Hiljem.php');
                break;

              default:
                  include('subPages/Avaleht.php'); 
                break;
            }
          } else {
            switch ($_GET['leht']) {
              default: 
                  include('subPages/sisene.php');
                break;
            }
          } ?>
      </div>

      <div class="navbar navbar-fixed-bottom ">
        <div class="navbar-inner">
          <div class="container">
            <center>
              <h6>&copy; Karli Ots 2013 & powered with 
                <a href="http://twitter.github.io/bootstrap/index.html" target="_blank">Bootstrap</a>
              </h6>
            </center>
          </div>
        </div>
      </div>

  </body>
</html>