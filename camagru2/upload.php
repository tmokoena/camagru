<?php
    if (isset($_POST['upload']))
    {
        $file = $_FILES['data'];

        $filename = $_FILES['data']['name'];
        $filetmpname = $_FILES['data']['tmp_name'];
        $filesize = $_FILES['data']['size'];
        $fileerror = $_FILES['data']['error'];
        $filetype = $_FILES['data']['type'];

        $fileext =explode('.', $filename);
        $ext = strtolower(end($fileext));

        $allowed = array('jpg','jpeg','png');

        if (in_array($ext,$allowed)){
            if($fileerror === 0){
                if($filesize < 1000000){
                    $fnnew = uniqid('', true).".".$ext;
                    $filedest = 'ppt/'.$fnnew;
                    move_uploaded_file($filetmpname, $filedest);
                    header('Location:home.php');
                }else{

                }
            }else{

            }
        }else{

        }
    }
?>