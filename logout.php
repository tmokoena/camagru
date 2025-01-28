<?php
    session_start();
    session_destroy();
    header('Location:index.php');

    // clean the temp folder
    $folder_path = "temp"; 
    
    $files = glob($folder_path.'/*');  
    
    foreach($files as $file) { 
        if(is_file($file))   
            unlink($file);  
    } 
?>