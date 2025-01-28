<?php
    function dbconn($dns, $usrname, $pwd)
    {
        try {
            $db = new PDO($dns,$usrname,$pwd);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return ($db);
        } catch (Exception $e) {
            return (NULL);
        }
        return (NULL);
    }
?>