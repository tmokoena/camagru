<?php
    session_start();
    require("config/setup.php");
    $err;
    if (!empty($_POST['email']) && !empty($_POST['pwd'] && !empty($_POST['sub'])))
    {
        require("config/connect.php");
        $email      =   trim(htmlspecialchars($_POST['email']));
        $upwd       =   hash("whirlpool",trim(htmlspecialchars($_POST['pwd'])));
    
        $sql        =   'SELECT * FROM users WHERE email = ?';
        $ex         =   $con->prepare($sql);
        
        
        try {
            $ex->execute([$email]);
            $usrdata = $ex->fetch(PDO::FETCH_ASSOC);
            if (strcmp($email,$usrdata['email']) == 0){   
                if ($upwd == $usrdata['pwd']){
                    if ($usrdata['active'] == 1){
                        $_SESSION['id'] = $usrdata['id'];
                        $_SESSION['username'] = $usrdata['username'];
                        header('Location:home.php');
                    }
                    else{
                        $err =  "Your account is not Active!";
                    }
                }else{
                    $err =  "Wrong password!";
                }
            }else{
                $err =  "wrong E-mail Address";
            }
        } catch (Exception $e) {
            $err =  "something went wrong!";
        }
        $con        =   NULL;
    }else{
        $err = "Please enter your login Details";
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
    <?php require_once('notlogheader.php'); ?>
    <div class = "wrap">
        <div class="login">
            <div class="frm">
                <div class="err">
                    <?php echo '<h3>'.$err.'</h3>' ?>
                </div>
                <form action="index.php" method="post">
                    <h3 class="title">E-Mail</h3>
                    <input type="text" name="email" class="text" placeholder="E-Mail">
                    <h3 class="title">Password</h3>
                    <input type="text" name="pwd" class="text" placeholder="PassWord">
                    <input type="submit" name ="sub" value="Login" class="text">
                </form>
                <div>
                    <hr>
                    <a class="link" href="register.php">Register</a>
                    <a class="link" href="reset.php">Reset Your Password</a>
                </div>
            </div>
        </div>
    </div>
    <?php require_once("footer.php");?>
</body>
</html>