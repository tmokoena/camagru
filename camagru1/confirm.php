<?php
    require("config/connect.php");

    $username = $_GET['username'];
    $key = $_GET['key'];
    $active = 1;

    $sql1       =   'SELECT * FROM users WHERE username = ?';
    $sql2       =   'UPDATE users SET active = :active WHERE username = :username';
    $ex         =   $con->prepare($sql1);
    
    try {
        $ex->execute([$username]);
        $usrdata = $ex->fetch(PDO::FETCH_ASSOC);
        if (strcmp($username,$usrdata['username']) == 0){
            if($key == $usrdata['regkey'])
            {
                $ex         =   $con->prepare($sql2);
                $ex->execute(['active'=>$active,'username'=>$username]);
                header('Location:activated.php');
            }
        }
    } catch (Exception $e) {
        echo "<h2>you are not registered!!</h2><br/>";
        echo $e->getmessage();
    }
    $con = NULL;
?>