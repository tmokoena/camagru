<?php
    require('config/connect.php');
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/gallery.css">
    <link rel="stylesheet" href="css/cam.css">
    <link rel="stylesheet" href="css/home.css">
    <title>Gallery</title>
</head>
<body>
    <?php
        if (isset($_SESSION['id'])) 
            require_once("header.php");
        else
        require_once("notlogheader.php");
    ?>
    <div class="ga">
    <?php
        $sql            =   'SELECT * FROM media';
        // $ex         =   $con->prepare($sql);
        // $ex->exec($sql);
        $ex =$con->query($sql);
        while($row = $ex->fetch(PDO::FETCH_ASSOC))
        {                           
            if(isset($_SESSION['id'])){
                echo    '
                <div class="post">
                    <div class="hpht">
                        <img src="'.$row['filename'].'" class="img" id="imgpht">
                        <form action="home.php" method="post">
                            <input type="hidden" name= "himg" id="himg" value="'.$row['filename'].'">
                            <button class="btn" type="submit" name="del">
                                Delete Post
                            </button>
                            <button class="btn" type="submit" name="like">
                                Like
                            </button>
                        </form>
                    </div>
                    <!-- post comments from the user to the database //the com-wrap holds all the comments controls-->
                    <div class="com-wrap">
                        <div class="form">
                            <form action="home.php" method="post">
                                <input type="hidden" name="cimg" id="cimg" value="'.$row['filename'].'">
                                <input class="hctxt" type="text" name="comment">
                                <input class="hcbtn"type="submit" value="Comment" name="com" id="com">
                            </form>
                        </div>
                        <div class="comments" id="comments">
                            <ul>';
                                // populate it with comments from table
                                $sql1            =   'SELECT * FROM comments WHERE filename=:filename';
                                $exs         =   $con->prepare($sql1);
                                $exs->execute(['filename'=>$row['filename']]);
                                
                                while($comments = $exs->fetch(PDO::FETCH_ASSOC))
                                {                           
                                    echo '<li>'.$comments['comment'].'</li>';
                                }
                        echo 
                            '</ul>
                        </div>
                    </div>
                </div>'; 
            }else{
                echo    '
                <div class="post">
                    <div class="hpht">
                        <img src="'.$row['filename'].'" class="img" id="imgpht">
                    </div>
                    <!-- post comments from the user to the database //the com-wrap holds all the comments controls-->
                    <div class="com-wrap">
                        <div class="comments" id="comments">
                            <ul>';
                                // populate it with comments from table
                                $sql1            =   'SELECT * FROM comments WHERE filename=:filename';
                                $exs         =   $con->prepare($sql1);
                                $exs->execute(['filename'=>$row['filename']]);
                                
                                while($comments = $exs->fetch(PDO::FETCH_ASSOC))
                                {                           
                                    echo '<li>'.$comments['comment'].'</li>';
                                }
                        echo 
                            '</ul>
                        </div>
                    </div>
                </div>'; 
            }
        }
    ?>
    </div>
    <?php require_once("footer.php");?>   
</body>
</html>