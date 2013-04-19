<?php
	error_reporting(E_ALL ^ E_NOTICE);
	session_start();
	$USERNAME = $databaseData->selectLoginUserInformation()['username'];
	$EMAIL = $databaseData->selectLoginUserInformation()['email'];
	$FIRSTNAME = $databaseData->selectLoginUserInformation()['firstname'];
	$LASTNAME = $databaseData->selectLoginUserInformation()['lastname'];
?>
<style type="text/css">.updateError{ display: none; } .updateSuccess{ display: none; }</style>
<div class="row">
	<div class="span3">
		<?php if (file_exists("profileImages/" . $USERNAME . '.jpg')) { ?>
			<img src="profileImages/<?=$USERNAME;?>.jpg" class="img-polaroid">
		<?php } else { ?>
			<img src="profileImages/anonymous.jpg" class="img-polaroid">
		<?php } ?>
		<div id="image">
			<form action="" method="post" enctype="multipart/form-data">
				<input type="file" name="file" placeholder="pilt" />
				<input type="submit" name="upload" value="Upload" class="btn"/>
			</form>

				<?php
					if (isset($_POST['upload'])) {
						checkImage($USERNAME);
					}

					function checkImage ($USERNAME) {
						if (!preg_match('/\\.(jpg)$/i', $_FILES['file']['name'])) {
						     echo "<span class='alert alert-danger'>Ainult .jpg laiendiga pilt lubatud!</span>";
						} else if ($_FILES['file']['size'] > 500000) {
							echo "<span class='label label-important'>Fail liiga suur!</span>";
						} else {
							if ($_FILES["file"]["error"] > 0) {
						    	echo "Error: " . $_FILES["file"]["error"] . "<br />";
							} else {
						    	if (file_exists("profileImages/" . $USERNAME . '.jpg')) {
						    		unlink("profileImages/" . $USERNAME . '.jpg');
						    		uploadFile($USERNAME);
						    	} else {
						      		uploadFile($USERNAME);
						      	}
						    }
						}
					}

					function uploadFile ($USERNAME) {
						move_uploaded_file($_FILES["file"]["tmp_name"], "profileImages/" . $USERNAME . '.jpg');
					}
				?>
		</div>
	</div>
	<div class="span8 well">
		<form>
			<div class="control-group info">
				<div class="controls">
				  	<label class="control-label">Kasutajanimi: </label>
				    <input type="text" class="triggerPopover" disabled="disabled" id="updateUsername" value="<?=$USERNAME;?>" 
				    data-original-title="Kasutajanimi vahemikus 6-20 tähemärki" />

				    <label class="control-label">Email: </label>
				    <input type="text" class="triggerPopover" id="updateEmail" value="<?=$EMAIL?>"
				    data-original-title="Email"  />

				    <label class="control-label">Eesnimi: </label>
				    <input type="text" class="triggerPopover" id="updateFirstname" value="<?=$FIRSTNAME;?>"
				    data-original-title="Eesnimi"  />


				    <label class="control-label">Perenimi: </label>
				    <input type="text" class="triggerPopover" id="updateLastname" value="<?=$LASTNAME;?>"
				    data-original-title="Perenimi"  />

				    <label class="control-label"></label>
				    <input type="submit" id="update" class="btn" value="Uuenda" />
				</div>
			</div>
		</form>
	<div class="alert alert-danger updateError"></div>
	<div class="alert alert-success updateSuccess">Andmed uuendatud</div>
	</div>
</div>