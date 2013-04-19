<style type="text/css">.songUsername{ margin-top: 0;} #buttons{margin-top: 60px; } .notifications{ overflow: auto; height: 500px;} .oneSong{ margin-left: 0; margin-right: -35px;} .oneFriend{ margin-left: 0; margin-right: -35px;} .song{ margin-left: 0;} .friend{ margin-left: 0;} .song{ margin-left: 0;} img{ width: 100px; height: 80px;}</style>
<ul class="nav nav-list span3 well">
    <li class="nav-header" >Teadaanded</li>
        <li><a class="tuttavad" href="index.php?leht=teadaanded&valik=tuttavad">Sõbrad</a></li>
        <li><a class="muusika" href="index.php?leht=teadaanded&valik=muusika" >Muusika</a></li>
        <li class="active koik" ><a href="index.php?leht=teadaanded&valik=koik" >Kõik</a></li>
    <li class="nav-header" >Ajalugu</li>
        <li><a href="index.php?leht=teadaanded&valik=uuemad" >Uuemad</a></li>
        <li><a href="index.php?leht=teadaanded&valik=vanemad" >Vanemad</a></li>
</ul>

<div class="well span6 notifications">
    <?php
        session_start();
        error_reporting(E_ALL ^ E_NOTICE);
        $userId = $_SESSION['user'];
        
        class notifications {
            //defining global variables for database connection
            private $_D_HOSTNAME;
            private $_D_USERNAME;
            private $_D_PASSWORD;
            private $_D_DATABASE;
            private $_CONNECTION;
            private $userId;

            //defining global variables for friend requests and music notifications
            private $seenFriendNotify = array();
            private $seenSongNotify = array();
            private $friendNotify = array();
            private $songNotify = array();

            //building object
            function __construct ($host, $user, $pass, $data, $userId) {
                $this->_D_DATABASE = $data;
                $this->_D_HOSTNAME = $host;
                $this->_D_PASSWORD = $pass;
                $this->_D_USERNAME = $user;
                $this->userId = $userId;
                notifications::buildConnection();
            }
            
            //making connection to database
            public function buildConnection () {
                $this->_CONNECTION = new mysqli($this->_D_HOSTNAME, $this->_D_USERNAME, $this->_D_PASSWORD, $this->_D_DATABASE) or die (mysql_error());
                $this->_CONNECTION->query('SET NAMES utf8');
                notifications::selectUserAllNotifications();
            }

            //returning user information when passed in only user id
            public function getUserInformation ($user) {
                $getInfo = $this->_CONNECTION->prepare("SELECT * FROM users WHERE id='$user'") or die (mysql_error());
                $getInfo->bind_result($id, $username, $password, $email, $firstname, $lastname);
                $getInfo->execute();
                if ($getInfo->fetch()) {
                    $notifiedUser['id'] = $id;
                    $notifiedUser['username'] = $username;
                    $notifiedUser['firstname'] = $firstname;
                    $notifiedUser['lastname'] = $lastname;
                    $recieved[] = $notifiedUser;
                }
                return $recieved;
            }
            
            //selecting all logged in user notifications
            public function selectUserAllNotifications () {
                $i = 0;
                $j = 0;
                $notification = $this->_CONNECTION->prepare("SELECT * FROM notifications WHERE friend_id='$this->userId'");
                $notification->bind_result($id, $user_id, $notify, $friend_id, $done_or_not);
                $notification->execute();
                while ($notification->fetch()) {
                    if ($done_or_not == 0) {
                        if ($notify == 'FRIEND') {
                            $this->friendNotify[$i] = $user_id;
                            $i++;
                        } else {
                            $songNotifyOne['id'] = $id;
                            $songNotifyOne['friendId'] = $user_id;
                            $songNotifyOne['url'] = $notify;
                            $this->songNotify[] =  $songNotifyOne;
                            $j++;
                        }
                    } else {
                        if ($notify == 'FRIEND') {
                            $this->seenFriendNotify[] = $user_id;
                        } else {
                            $this->seenSongNotify[] = $notify;
                        }
                    }
                }
            }

            //showing only friend requests
            public function selectFriendNotifications () {
                $countedFriendNotifications = count($this->friendNotify);
                for ($i=0; $i<$countedFriendNotifications; $i++) {
                    $profileImage = notifications::getUserInformation($this->friendNotify[$i])[0]['username'].'.jpg';
                    $userId = notifications::getUserInformation($this->friendNotify[$i])[0]['id'];
                    echo '
                        <div class="span5 friend well">
                        <div class="span2 oneFriend">';
                            if (file_exists("profileImages/" . $profileImage)) {
                                echo '<img src="profileImages/'.$profileImage.'" class="img-polaroid"></div>Kasutaja: <b>';
                            } else {
                                echo '<img src="profileImages/anonymous.jpg" class="img-polaroid"></div>Kasutaja: <b>';
                            }
                            
                            echo notifications::getUserInformation($this->friendNotify[$i])[0]['firstname'].' ';
                            echo notifications::getUserInformation($this->friendNotify[$i])[0]['lastname'];
                    
                        echo '</b> soovib olla teie sõber<br /><h6><small>Kasutajanimi: ';
                        echo notifications::getUserInformation($this->friendNotify[$i])[0]['username'];
                        echo '</small></h6><button class="pull-right btn kinnita" id="kinnita" value="'.$userId.'">Nõustu</button></div>';
                }
            }

            //showing only music notifications
            public function selectMusicNotifications () {
                $countedSongNotifications = count($this->songNotify);
                for ($i=0; $i<$countedSongNotifications; $i++) {
                    $profileImage = notifications::getUserInformation($this->songNotify[$i]['friendId'])[0]['username'].'.jpg';
                    $songUrl = $this->songNotify[$i]['url'];
                    $id = $this->songNotify[$i]['id'];
                
                      echo '
                        <div class="span5 song well">
                        <div class="span2 oneSong">';
                            if (file_exists("profileImages/" . $profileImage)) {
                                echo '<img src="profileImages/'.$profileImage.'" class="img-polaroid"></div>';
                            } else {
                                echo '<img src="profileImages/anonymous.jpg" class="img-polaroid"></div>';
                            }
                    
                        echo '<h6 class="pull-left songUsername"><small>';
                        echo notifications::getUserInformation($this->songNotify[$i]['friendId'])[0]['username'];
                        echo '</small></h6>
                            <div id="buttons" class="pull-right input-append">
                                <button class="btn kuula" id="kuula" value="'.$songUrl.'">Kuula</button>
                                <button class="btn eemalda" id="eemalda" value="'.$id.'">Eemalda</button>
                            </div></div>';
                }
            }
        }

    $notification = new notifications('127.0.0.1', 'root', '' ,'karli', $userId);

    if (isset($_GET['valik'])) {
        if ($_GET['valik'] == 'tuttavad') {
            $notification->selectFriendNotifications();
        } else if ($_GET['valik'] == 'muusika') {
            $notification->selectMusicNotifications();
        } else if ($_GET['valik'] == 'koik') {
            $notification->selectFriendNotifications();
            $notification->selectMusicNotifications();
        }
    }
    ?>
</div>

<div id="notifications" class="modal hide fade" >
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h5>Video soovitus</h5>
  </div>
  <div class="music_notify modal-body"></div>

  <div class="modal-footer"></div>
</div>