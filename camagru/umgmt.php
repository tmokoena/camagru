<?php
    require("config/connect.php");

    $id = 2;
    $sql1       =   'SELECT * FROM users WHERE id = ?';        
    $sql2       =   'UPDATE users SET username = :username, email = :email WHERE id = :id';
    $sql3       =   'UPDATE users SET username = :username, email = :email, pwd = :pwd WHERE id = :id';

    if (!empty($_POST['sub']) && $_POST['email'] != '' && $_POST['username'] != '')
    { 
        $username   =   trim(htmlspecialchars($_POST['username']));
        $email      =   trim(htmlspecialchars($_POST['email']));
             
        if ($_POST['change'] == 'on'){
            $ex     =   $con->prepare($sql1);
            $ex->execute([$id]);
            $usrdata    =   $ex->fetch(PDO::FETCH_ASSOC);

            $upwd   =   hash("md5",trim(htmlspecialchars($_POST['conpwd'])));
            $oldpwd   =   hash("md5",trim(htmlspecialchars($_POST['oldpwd'])));

            if (strcmp($usrdata['pwd'], $oldpwd) == 0){
                $ex     =   $con->prepare($sql3);
                $ex->execute(['username'=>$username, 'email'=>$email, 'pwd'=>$upwd, 'id'=>$id]);
            }else{
            }
        }else{
            $ex     =   $con->prepare($sql2);
            $ex->execute(['username'=>$username, 'email'=>$email, 'id'=>$id]);
        }
    }else{
        $ex         =   $con->prepare($sql1);
        $ex->execute([$id]);
        $usrdata    =   $ex->fetch(PDO::FETCH_ASSOC);
    }
    $con    =   NULL;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Account Management</title>
    <link rel="stylesheet" href="css/umgmt.css">
    <script src="js/checked.js"></script>
</head>
<body>
    <div class ="header">
        <p>Account Management</p>
    </div>
    <div class = "form">
        <form action="umgmt.php" method="post" onsubmit="return validate()">
            <div class="error">
                <input type="text" name="username" class="text" id="11" value = <?php if(!empty($usrdata['username'])){ echo ($usrdata['username']);}else{echo $_POST['username'];}?>>
                <h4 id="uerror"></h4>
            </div>
            <div class="error">
                <input type="email" name="email" class="text" id="22" value = <?php if(!empty($usrdata['email'])){ echo ($usrdata['email']);}else{echo $_POST['email'];}?>>
                <h4 id="eerror"></h4>
            </div>
            <div class="chng">
                Change Password :
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
</body>
</html>