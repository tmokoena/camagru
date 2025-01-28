<?php
    require("config/connect.php");

    if (!empty($_POST['reset']) && $_POST['npwd'] != '' && $_POST['email'] != '')
    { 
        $email  =   trim(htmlspecialchars($_POST['email']));
        $sql    =   'UPDATE users SET pwd = :npwd WHERE email = :email';
        $npwd   =   hash("whirlpool",trim(htmlspecialchars($_POST['npwd'])));
        $ex     =   $con->prepare($sql);
          

        try{
            $ex->execute(['npwd'=>$npwd,'email'=>$email]);
            header('Location:thankyou.php');
        }catch(Exeption $e){
            echo "password Not Changed!!";
        }
    }
    $con        =   NULL;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link rel="stylesheet" href="css/umgmt.css">
    <script src="js/valcpwd.js"></script>
</head>
<body>
    <div class ="header">
        <p>Account Management: Change Password</p>
    </div>
    <div class="form">
        <form action="changepwd.php" method="POST" onsubmit="return valcpwd()">
            <input type="hidden" name="email" class="text pass" value ="<?php echo $_GET['email']?>">
            <div class="error">
                <input type="text" name="npwd" class="text pass" placeholder= "New Password" id="2" onkeyup="same()">
            </div>
            <div>
                <input type="text" name="conpwd" class="text pass" placeholder= "Confirm Password" id="3" onkeyup="same()">
                <h4 id="eerror"></h4>
            </div>
            <input type="submit" value="Reset" name="reset" class="text" id="mit">
        </form>
    </div>
</body>
</html>