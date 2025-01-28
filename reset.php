<?php
$err = 'Please Insert Your Recorvery E-Mail Address!';
    if (!empty($_POST['email']) && !empty($_POST['sub']))
    {
        require("config/connect.php");
        $email      =   trim(htmlspecialchars($_POST['email']));
    
        $sql        =   'SELECT * FROM users WHERE email = ?';
        $ex         =   $con->prepare($sql);
        $ex->execute([$email]);
        $usrdata = $ex->fetch(PDO::FETCH_ASSOC);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $err  = 'Invalid E-mail Format!';
        }else{
            if (strcmp($email, $usrdata['email']) == 0){
                
                $msg        =   "Click the this link to reset your password :\n http://localhost:8080/camagru/changepwd.php?email=$email";
                if (mail($email,"Reset Password",$msg,"From: DoNoReply@Camagru.com") == 1)
                    header('Location:thankyou.php');
            }else{
                $err =  "Account Doesn't Exist!";
            }
        }
    }

    $con = NULL;
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/cam.css">
    <link rel="stylesheet" href="css/login.css">
    <script src="js/val.js"></script>
    <title>Forgot Password</title>
</head>
<body>
<?php require_once("notlogheader.php");?>
    <div class = "wrap">
        <div class="relogin">
            <div class="frm">
                <div class="err">
                    <?php echo '<h3>'.$err.'</h3>' ?>
                </div>
                <form action="reset.php" method="post" onsubmit="return val()">
                <div>
                    <input class="text" type="email" name="email" id="email" placeholder="E-Mail">
                    <center><h3 id="eerror"></h3></center>
                </div>
                    <input class="text" name="sub" type="submit" value="Send Reset Link">
                </form>
            </div>
        </div>
    </div>
<?php require_once("footer.php");?>
</body>
</html>