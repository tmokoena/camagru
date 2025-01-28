<?php 
require("config/connect.php");
session_start();

if (isset($_SESSION['id']) && isset($_SESSION['username'])){
    $id = $_SESSION['id'];
    // this is the uploading algorithm that pushes the file
    // to the database and moves the file to the data folder
    if (isset($_POST['up'])){
        $sql        =   'INSERT INTO media (uid, filename,email) VALUES(:uid, :img, :un)';
        $imgc        =   htmlspecialchars(trim($_POST['src']));
        $img        =   explode("/",$imgc)[1];
        $dest       =   "data/";
        
        rename($imgc,$dest.$img);
        try {
            $ex         =   $con->prepare($sql);
            $ex->execute(['uid'=>$id,'img'=>$dest.$img, 'un'=>$_SESSION['email']]);
            $sql        =   'INSERT INTO likes(filename, uid) VALUES(:fname, :uid)';
            $ex         =   $con->prepare($sql);
            $ex->execute(['fname'=>$dest.$img,'uid'=>$id]);
        } catch (excption $e) {
            echo $e;
        }
    }
    // this code creates ofline pngs from the live preview to the 
    // canvas to the png(throu javascript cam.js)
    if (isset($_POST['sub']) != NULL){
        $img = $_POST['img'];
        $imgstck = $_POST['stck'];
        // echo $imgstck;
        $img = str_replace('data:image/png;base64,', '', $img);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);
        $filename = "temp/".time().".png";
        file_put_contents($filename, $data);


        list($width, $height) = getimagesize($imgstck);
        
        $imgsec = imagecreatefromstring(file_get_contents($filename));
        $imgstcksec = imagecreatefromstring(file_get_contents($imgstck));
        imagecopymerge($imgsec, $imgstcksec, 0, 100, 0, 0, $width, $height, 85);
        imagepng($imgsec, $filename);
        $_POST['sub'] = NULL;
    }
    // this code deletes the file from the preview div
    if (isset($_POST['down']))
        if (explode(".",$_POST['src'])[1] == 'png' && explode("/",$_POST['src'])[0] == 'temp')
            unlink($_POST['src']);


    // this file handles files upload through the file object
    if (isset($_POST['lup'])){

        $filename = $_FILES['file']['name'];
        $filesize = $_FILES['file']['size'];
        $filesize = $_FILES['file']['type'];
        $filetemploc = $_FILES['file']['tmp_name'];
        $dest = 'temp/'.time().'.png';
        $imgstck = $_POST['txtsec'];

        move_uploaded_file($filetemploc,$dest);

        list($width, $height) = getimagesize($imgstck);

        $imgsec = imagecreatefromstring(file_get_contents($dest));
        $imgstcksec = imagecreatefromstring(file_get_contents($imgstck));
        imagecopymerge($imgsec, $imgstcksec, 0, 100, 0, 0, $width, $height, 100);
        imagepng($imgsec,$dest);
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
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="css/cam.css">
    <title>Take a Photo</title>
</head>
<body>
    <?php require_once("header.php");?>
    <div class="bdy">
            
            <div class="cam">
                <input type="hidden" id="src">
                <video class="vid" id="video" class="vid" autoplay="true"></video>
                <!-- <div class="btn"> -->
                    <input type="button" value="Capture" id="btn" class="b" disabled='true'>
                    <button id="upload" name="lup" class="b" disabled='true'>
                        From File
                    </button>
                <!-- </div> -->
                <div class="stck">
                    <button id="btf">
                        <img src="stickers/btf.jpg" class="img">
                    </button>
                    <button id="rex">
                        <img src="stickers/rex.png" class="img">
                    </button>
                    <button id="tt">
                        <img src="stickers/tt.jpg" class="img">
                    </button>
                </div>
            </div>
            <div class="prev">
                <?php 
                    $dir = "temp/";
                    $files = scandir($dir); 
                    if (count($files) >0){
                        for ($i=0; $i < count($files); $i++) {
                            $file = $files[$i];
                            if (explode(".",$file)[1] == "png"){
                            echo '<div class="col">
                                    <form action="cam.php" method="post">
                                        <input type="hidden" name="src" value="'.$dir.$file.'">
                                        <div class="pht">
                                            <img src="'.$dir.$file.'" width="300px" height="300px">
                                        </div>
                                        <input type="submit" name="up" value="Upload" class="up">
                                        <input type="submit" name="down" value="Drop" class="up">
                                    </form>
                                </div>';
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <?php require_once("footer.php");?>
    <script src="js/cam.js"></script>
</body>
</html>