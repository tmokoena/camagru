<?php
    require("config/connect.php");
    $sql        =   'SELECT * FROM temp';
    $ex         =   $con->query($sql);
    foreach($ex as $e)
    {
        //  echo $e[1];
        
         echo "<img height='400' width=400 src=$e[1]/ß>";
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
</body>
</html>