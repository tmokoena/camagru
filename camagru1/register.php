<?php
    $err='';
    if (!empty($_POST['email']) && !empty($_POST['username']) && !empty($_POST['pwd'] && !empty($_POST['sub'])))
    {   
        require("config/connect.php");
        $email      =   trim(htmlspecialchars($_POST['email']));
        $upwd       =   hash("whirlpool",trim(htmlspecialchars($_POST['pwd'])));
        $username   =   trim(htmlspecialchars($_POST['username']));
        $regkey = rand(0,10000);

        $sql        =   'INSERT INTO users(username, email, pwd, regkey) VALUES(:username, :email, :pwds, :regkey)';
        $ex         =   $con->prepare($sql);
        try {
            $ex->execute(['username'=>$username, 'email'=>$email, 'pwds'=>$upwd, 'regkey'=>$regkey]);
            $msg        =   "http://localhost:8080/camagru/confirm.php?username=$username&key=$regkey";
            if (mail($email,"Camagru Account Activation",$msg,"From: DoNoReply@Camagru.com") == 1)
                header('Location:thankyou.php');
        } catch (Exception $e) {
            echo "The account alread Exists!";
        }
        $con        =   NULL;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/cam.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Home: Camagru</title>
</head>
<body>
    <?php require_once("notlogheader.php");?>
    <div class = "wrap">
            <div class="rlogin">
                <div class="frm">
                    <div class="err">
                        <?php echo '<h3>'.$err.'</h3>' ?>
                    </div>
                    <form action="register.php" method="post">
                        <h3>Username</h3>
                        <input type="text" name="username" class="text" placeholder="Username">
                        <h3>E-Mail</h3>
                        <input type="text" name="email" class="text" placeholder="E-Mail">
                        <h3>Password</h3>
                        <input type="password" name="pwd" class="text" placeholder="PassWord">
                        <input type="submit" name="sub" value="Register" class="text">
                    </form>
                </div>
            </div>
    </div>
    <?php require_once("footer.php");?>
</body>
</html>