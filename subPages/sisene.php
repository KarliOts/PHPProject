<link rel="stylesheet" type="text/css" href="css/homeStyle.css" />
<script type="text/javascript" src="../js/jquery.js"></script>

<div class="row terveSisu">
    <div class="span8">
        <div class="row">
            <div class="span7 galerii well">
                <?php include('avalehePildid.php'); ?>
            </div>
            <div class="span7 well">
                <h4><?=$databaseData->selectHomepageContent()[0]['heading']?></h4>
                <p><?=$databaseData->selectHomepageContent()[0]['text']?></p>
                <small class="pull-right"><?=$databaseData->selectHomepageContent()[0]['date']?></small>
            </div>
        </div>
    </div>
    
    <div class="span4">
        <div class="login well">
            <form id="sisene" method="post"> 
            <input type="text" class=" username input-large" placeholder="Kasutajanimi"></br>
            <input type="password" class="password input-large" placeholder="Parool"></br>
            &nbsp;<button type="submit" class="btn btn-small btn-primary">Sisene</button>
            &nbsp;<h6>Pole kontot <a class="toggle-register" href="#">Registreeru</a></h6>
            </form>
            <div class="loginmessage"></div>
        </div>

        <div class="register well">
            <form id="register" method="post">  
            <input type="text" class="firstname input-large" placeholder="* Eesnimi"></br>
            <input type="text" class="lastname input-large" placeholder="* Perenimi"></br>
            <input type="text" class="email input-large" placeholder="* Email"></br>
            <input type="text" class="r_username input-large" placeholder="* Kasutajanimi"></br>
            <input type="password" class="r_password input-large" placeholder="* Parool"></br>
            <input type="password" class="password_control input-large" placeholder="* Parool teist korda"></br>
            &nbsp;<button type="submit" class="btn btn-small btn-primary">Registreeru</button>
            </form>

            <div class="registermessage"></div>
        </div>
    </div>
</div>





























































<!--




    <div class="register">
        <form id="register" method="post">  
        &nbsp;&nbsp;<input type="text" class="firstname input-large" placeholder="* Eesnimi"></br>
        &nbsp;&nbsp;<input type="text" class="lastname input-large" placeholder="* Perenimi"></br>
        &nbsp;&nbsp;<input type="text" class="email input-large" placeholder="* Email"></br>
        &nbsp;&nbsp;<input type="text" class="r_username input-large" placeholder="* Kasutajanimi"></br>
        &nbsp;&nbsp;<input type="password" class="r_password input-large" placeholder="* Parool"></br>
        &nbsp;&nbsp;<input type="password" class="password_control input-large" placeholder="* Parool teist korda"></br>
        &nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-small btn-primary">Registreeru</button>
        </form>
        <div class="registermessage"></div>
    </div>

    <div class="login">
        <form id="sisene" method="post"> 
        &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class=" username input-large" placeholder="Kasutajanimi"></br>
        &nbsp;&nbsp;&nbsp;&nbsp;<input type="password" class="password input-large" placeholder="Parool"></br>
        &nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-small btn-primary">Sisene</button>
        </form>
        <div class="loginmessage"></div>
    </div>