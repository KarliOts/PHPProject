<?php 
error_reporting(E_ALL ^ E_NOTICE);
session_start();
if ($_SESSION['user'] != '') {
	include("menu_2.php");
}
if($_SESSION['user'] == ''){
?>
<div class="span12">
	<div class="span1"></div>
	<div class="span3 well">
		</br>
			<form id="sisene" method="post"> 
				&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class=" username input-large" placeholder="Kasutajanimi"></br>
					&nbsp;&nbsp;&nbsp;&nbsp;<input type="password" class="password input-large" placeholder="Parool"></br>
					&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-small btn-primary">Sisene</button>
			</form>
		<div class="loginmessage"></div></div>
	<div class="span7 well">
		<div class="span5">
		</br>
			<form id="register" method="post">	
	  			&nbsp;&nbsp;<input type="text" class="firstname input-large" placeholder="* Eesnimi"></br>
	  			&nbsp;&nbsp;<input type="text" class="lastname input-large" placeholder="* Perenimi"></br>
	  			&nbsp;&nbsp;<input type="text" class="email input-large" placeholder="* Email"></br>
	  			&nbsp;&nbsp;<input type="text" class="r_username input-large" placeholder="* Kasutajanimi"></br>
	  			&nbsp;&nbsp;<input type="password" class="r_password input-large" placeholder="* Parool"></br>
	  			&nbsp;&nbsp;<input type="password" class="password_control input-large" placeholder="* Parool teist korda"></br>
	  			&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-small btn-primary">Registreeru</button>
			</form> 
		</div>
		</br>
		<div class="span7 well">
			<p>Registreerimine töökorras</p>
			* Tähistatud kohad peab täitma!</br></br>
			1) Kasutajanimi vähemalt 6 märki pikk!</br></br>
			2) Parool vähemalt 8 märki pikk!</br></br>
		</div></div>
</div> 
<?php }?>