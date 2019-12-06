<?php
    require('config/connect.php');
    session_start();
    if (isset($_POST['com']) && $_POST['comment'] != '')
    {   
        $id             =   $_SESSION['id'];
        $filename       =   htmlspecialchars(trim($_POST['cimg']));
        $comment        =   htmlspecialchars(trim($_POST['comment']));
        $sql            =   'INSERT INTO comments(filename,uid,comment) VALUES (:filename, :id, :comment)';
        $ex             =   $con->prepare($sql);
        $ex->execute(['filename'=>$filename,'id'=>$id,'comment'=>$comment]);

        $sql = 'SELECT * FROM media WHERE filename=?';
        $ex             =   $con->prepare($sql);
        $ex->execute([$filename]);
        $usrdata = $ex->fetch(PDO::FETCH_ASSOC);
        if($usrdata['uid'] != $_SESSION['id']){
            $msg        =   "Hi Your friend ".$_SESSION['username']." just commented on your post";
            mail($usrdata['email'],"Camagru Post Notification",$msg,"From: DoNoReply@Camagru.com");
        }
        
    }
        if(isset($_POST['del'])){
            $id             =   $_SESSION['id'];
            $filename       =   htmlspecialchars(trim($_POST['himg']));
            //delete the comments related to the file from the comments table
            $sql = 'DELETE FROM comments WHERE filename=:filename';
            $ex             =   $con->prepare($sql);
            $ex->execute(['filename'=>$filename]);
            //delete the likes related to the file from the likes table
            $sql = 'DELETE FROM likes WHERE filename=:filename';
            $ex             =   $con->prepare($sql);
            $ex->execute(['filename'=>$filename]);
            //delete the file from the media table
            $sql = 'DELETE FROM media WHERE filename=:filename';
            $ex             =   $con->prepare($sql);
            $ex->execute(['filename'=>$filename]);
            //delete the file from the data folder
            unlink($filename);
        }

        if (isset($_POST['like']))
        {
            $filename       =   htmlspecialchars(trim($_POST['himg']));
            $sql            =   'SELECT * FROM likes WHERE filename=:fn';
            $ex             =   $con->prepare($sql);
            $ex->execute(['fn'=>$filename]);
            $usrdata = $ex->fetch(PDO::FETCH_ASSOC);

            $lik = $usrdata['lik']+1;

            $sql2       =   'UPDATE likes SET lik=:lik WHERE filename=:fn';
            $ex             =   $con->prepare($sql2);
            $ex->execute(['lik'=>$lik, 'fn'=>$filename]);
        }
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
        $sql        =   'SELECT * FROM media';
        $ex         =   $con->query($sql);
    
        $nop =5;
        $data = $ex->fetchall(PDO::FETCH_ASSOC);
    
        $nopa = ceil(count($data)/$nop);
    
        if (!isset($_GET['page']))
            $page = 1;
        else
            $page = $_GET['page'];
    
        $j = (($page-1)*5);
        // $sql2        =   "SELECT * FROM comments LIMIT ".$j.','.$nop;
        $sql2            =   "SELECT * FROM media LIMIT ".$j.','.$nop;
        // $ex         =   $con->prepare($sql2);
        // $ex->exec($sql);
        $ex             =   $con->query($sql2);
        while($row = $ex->fetch(PDO::FETCH_ASSOC))
        {                           
            if(isset($_SESSION['id'])){
                echo    '
                <div class="post">
                    <div class="hpht">
                        <img src="'.$row['filename'].'" class="img" id="imgpht">
                        <form action="gallery.php" method="post">
                            <input type="hidden" name= "himg" id="himg" value="'.$row['filename'].'">';
                            if($row['uid'] == $_SESSION['id']){
                                echo    '<button class="btn" type="submit" name="del">
                                            Delete Post
                                        </button>';
                            }
                            $sql1            =   'SELECT * FROM likes WHERE filename=:fn';
                            $exs             =   $con->prepare($sql1);
                            $exs->execute(['fn'=>$row['filename']]);
                            $like = $exs->fetch(PDO::FETCH_ASSOC);
                    echo    '<button class="btn" type="submit" name="like">
                                Likes ('.$like['lik'].')
                            </button>
                        </form>
                    </div>
                    <!-- post comments from the user to the database //the com-wrap holds all the comments controls-->
                    <div class="com-wrap">
                        <div class="form">
                            <form action="gallery.php" method="post">
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
        echo '<div class="pg">Pages: ';
        for($i =1;$i<=$nopa;$i++)
        {
            if ($i >1)
                echo '-';
            echo '<a href="gallery.php?page='.$i.'">'.$i.'</a>';
        }
        echo '</div>'
    ?>
    </div>
    <?php require_once("footer.php");?>   
</body>
</div>
</html>