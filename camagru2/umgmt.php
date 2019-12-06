<?php
    require("config/connect.php");
    session_start();

    if (isset($_SESSION['id']) && isset($_SESSION['username'])){

        $id = $_SESSION['id'];
        $sql1       =   'SELECT * FROM users WHERE id = ?';        
        $sql2       =   'UPDATE users SET username = :username, email = :email, notifications = :notif WHERE id = :id';
        $sql3       =   'UPDATE users SET username = :username, email = :email, notifications = :notif, pwd = :pwd WHERE id = :id';
        $notif      =   0;
        $err = '';
        if (!empty($_POST['sub']) && $_POST['email'] != '' && $_POST['username'] != '')
        { 
            $username   =   trim(htmlspecialchars($_POST['username']));
            $email      =   trim(htmlspecialchars($_POST['email']));
            if (isset($_POST['notif'])){if ($_POST['notif'] == 'on'){$notif = 1;}else{$notif = 0;};}

            if (isset($_POST['change'])){
                if($_POST['change'] == 'on'){
                    $ex     =   $con->prepare($sql1);
                    $ex->execute([$id]);
                    $usrdata    =   $ex->fetch(PDO::FETCH_ASSOC);

                    $upwd   =   hash("whirlpool",trim(htmlspecialchars($_POST['conpwd'])));
                    $oldpwd   =   hash("whirlpool",trim(htmlspecialchars($_POST['oldpwd'])));

                    if (strcmp($usrdata['pwd'], $oldpwd) == 0){
                        $ex     =   $con->prepare($sql3);
                        $ex->execute(['username'=>$username, 'email'=>$email, 'notif'=>$notif, 'pwd'=>$upwd, 'id'=>$id]);
                    }else{
                        $err = "Your Old Password Is Wrong!";
                    }
                }
            }else{
                $ex     =   $con->prepare($sql2);
                $ex->execute(['username'=>$username, 'email'=>$email, 'notif'=>$notif, 'id'=>$id]);
            }
        }else{
            $ex         =   $con->prepare($sql1);
            $ex->execute([$id]);
            $usrdata    =   $ex->fetch(PDO::FETCH_ASSOC);
            $notif = $usrdata['notifications'];
        }
        $con    =   NULL;
    }else{
        header('Location:index.php');
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Management</title>
    <link rel="stylesheet" href="css/umgmt.css">
    <link rel="stylesheet" href="css/cam.css">
    <script src="js/checked.js"></script>
</head>
<body>
    <?php require_once("header.php");?>
    <!-- <div class ="header">
        <p>Account Management</p>
    </div> -->
    <div class="pbody">
        <div class = "pform">
            <form action="umgmt.php" method="post" onsubmit="return validate()">
                    <h4 id="uerror"><?php echo $err ?></h4>
                <div class="error">
                    <input type="text" name="username" class="text" id="11" value = <?php if(!empty($usrdata['username'])){ echo ($usrdata['username']);}else{echo $_POST['username'];}?>>
                </div>
                <div class="error">
                    <input type="email" name="email" class="text" id="22" value = <?php if(!empty($usrdata['email'])){ echo ($usrdata['email']);}else{echo $_POST['email'];}?>>
                    <h4 id="eerror"></h4>
                </div>
                <div class="chng">
                    Recieve_Notifications :
                    <input type="checkbox" name="notif" <?php if ($notif == 0){echo "unchecked";}else{echo "checked";}?>>
                </div>
                <div class="chng">
                    Change____Password :
                    <input id ='chk' type="checkbox" name="change" onclick="enable_text()">
                </div>
                <div class="error">
                    <input type="text" name="oldpwd" class="text pass" placeholder= "Old Password" disabled='true' id="1">
                    <h4 id="oldperror"></h4>
                </div>
                <div class="error">
                    <input type="text" name="newpwd" class="text pass" placeholder= "New Password" disabled='true' id="2" onkeyup="same()">
                    <h4 id="nerror"></h4>
                </div>
                <div>
                    <input type="text" name="conpwd" class="text pass" placeholder= "Confirm Password" disabled='true' id="3" onkeyup="same()">
                    <h4 id="cerror"></h4>
                </div>
                <input type="submit" value="Update" name="sub" class="text" id="mit">
            </form>
        </div>
    </div>
    <?php require_once("footer.php");?>
</body>
</html>