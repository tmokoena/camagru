<?php
        require("connect.php");
        $con = dbconn($dsn,$user,$pwd);
        $sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname";
        $con->exec($sql_create_db);
        $sql_create_user_table = "CREATE TABLE IF NOT EXISTS $dbname.users
                            (
                                `id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
                                `username` VARCHAR(25) NOT NULL UNIQUE,
                                `email` VARCHAR(255) NOT NULL UNIQUE,
                                `pwd` VARCHAR(255) NOT NULL,
                                `active` BOOLEAN DEFAULT FALSE,
                                `regkey` INT(6),
                                `notifications` BOOLEAN DEFAULT FALSE
                            )";
        $con->exec($sql_create_user_table);
        $Sql_create_data_table = "CREATE TABLE IF NOT EXISTS $dbname.media
                                (
                                    `id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
                                    `uid` INT UNSIGNED NOT NULL,
                                    FOREIGN KEY (`uid`) REFERENCES camagru.users(id),
                                    `filename` TEXT NOT NULL,
                                    `date` DATETIME NOT NULL
                                )";
        $con->exec($Sql_create_data_table);
        $Sql_create_comments_table = "CREATE TABLE IF NOT EXISTS $dbname.comments
                                (
                                    `id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
                                    `uid` INT UNSIGNED NOT NULL,
                                    FOREIGN KEY (`uid`) REFERENCES camagru.users(id),
                                    `comment` TEXT NOT NULL,
                                    `date` DATETIME NOT NULL
                                )";
        $con->exec($Sql_create_comments_table);
        $sql_create_user_table = "CREATE TABLE IF NOT EXISTS $dbname.likes
                                (
                                    `id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
                                    `uid` INT UNSIGNED NOT NULL,
                                    FOREIGN KEY (`uid`) REFERENCES camagru.users(id),
                                    `like` BOOLEAN NOT NULL DEFAULT FALSE
                                )";
        $con->exec($sql_create_user_table);
        $con = NULL;
?>