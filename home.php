<?php
    require('config/connect.php');
    session_start();

    if (isset($_SESSION['id']) && isset($_SESSION['username'])){
        if (isset($_POST['com']) && $_POST['comment'] != '')
        {   
            $id             =   $_SESSION['id'];
            $filename       =   htmlspecialchars(trim($_POST['cimg']));
            $fl             =   $filename;
            $comment        =   htmlspecialchars(trim($_POST['comment']));
            $sql            =   'INSERT INTO comments(filename,uid,comment) VALUES (:filename, :id, :comment)';
            $ex             =   $con->prepare($sql);
            $ex->execute(['filename'=>$filename,'id'=>$id,'comment'=>$comment]);
        }

        if(isset($_POST['del'])){
            $id             =   $_SESSION['id'];
            $filename       =   htmlspecialchars(trim($_POST['himg']));

            $ex = $con->prepare('
                select * from media as m
                INNER join users as u on m.uid = u.id
                where
                    m.uid = :id
                    AND
                    m.filename = :fn');
            // $ex->execute(array($_SESSION['id'], $filename), array(PDO::par));
            try
            {
                $ex->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
                $ex->bindParam(':fn', $filename, PDO::PARAM_STR);
                $ex->execute();
                // $result = $ex->SetFetchMode(PDO::FETCH_ASSOC);
                // echo $tot;
                $count = $ex->rowCount();
                if ($count == 1){
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
                //delete the comments related to the file from the comments table
            }
            catch(PDOException $ex)
            {
                echo $ex->getMessage();
            }
        }
        
        if(isset($_POST['like'])){
            $sql = 'UPDATE *';
        }
    }else{
        header('Location:index.php');
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
    <?php require_once("header.php");?>
    <div class="ga" id="ga">
        <?php
        $id             =   $_SESSION['id'];
        $sql            =   'SELECT * FROM media WHERE uid=:id';
        $ex         =   $con->prepare($sql);
        $ex->execute(['id'=>$id]);
        
        while($row = $ex->fetch(PDO::FETCH_ASSOC))
        {                           
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
        }
    ?>
    </div>
    <?php require_once("footer.php");?>   
    <script src="js/home.js"></script>
</body>
</html>