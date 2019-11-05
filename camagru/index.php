<?php
    require("config/setup.php");
    if (!empty($_POST['email']) && !empty($_POST['pwd'] && !empty($_POST['sub'])))
    {
        require("config/connect.php");
        $email      =   trim(htmlspecialchars($_POST['email']));
        $upwd       =   hash("md5",trim(htmlspecialchars($_POST['pwd'])));
    
        $sql        =   'SELECT * FROM users WHERE email = ?';
        $ex         =   $con->prepare($sql);
        
        
        try {
            $ex->execute([$email]);
            $usrdata = $ex->fetch(PDO::FETCH_ASSOC);
            if (strcmp($email,$usrdata['email']) == 0){   
                if ($upwd == $usrdata['pwd']){
                    if ($usrdata['active'] == 1){
                        header('Location:home.php');
                    }
                    else{
                        echo "Your account is not Active!";
                    }
                }else{
                    echo "Wrong password!";
                }
            }else{
                echo "wrong E-mail Address";
            }
        } catch (Exception $e) {
            echo "something went wrong!";
        }
        $con        =   NULL;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Home: Camagru</title>
</head>
<body>
    <div>
        <form action="index.php" method="post">
            <h3>E-Mail</h3>
            <input type="text" name="email" class="text">
            <h3>Password</h3>
            <input type="text" name="pwd" class="text">
            <input type="submit" name ="sub" value="Login">
        </form>
        <div>
            <hr>
            <a href="register.php">Register</a>
        </div>
    </div>
</body>
</html>