<?php
        require("connect.php");
        $con = dbconn($dsn,$user,$pwd);
        $sql_create_db = "CREATE DATABASE IF NOT EXISTS $dbname";
        $con->exec($sql_create_db);
        $sql_create_user_table = "CREATE TABLE IF NOT EXISTS $dbname.users
                            (
                                `id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
                                `username` VARCHAR(255) NOT NULL UNIQUE,
                                `email` VARCHAR(255) NOT NULL UNIQUE,
                                `pwd` VARCHAR(255) NOT NULL,
                                `active` BOOLEAN DEFAULT FALSE,
                                `regkey` INT(6),
                                `notifications` BOOLEAN DEFAULT TRUE
                            )";
        $con->exec($sql_create_user_table);
        $Sql_create_data_table = "CREATE TABLE IF NOT EXISTS $dbname.media
                                (
                                    `id` INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
                                    `uid` INT UNSIGNED NOT NULL,
                                    `filename` TEXT NOT NULL,
                                    `email` TEXT NOT NULL
                                )";
        $con->exec($Sql_create_data_table);
        $Sql_create_comments_table = "CREATE TABLE IF NOT EXISTS $dbname.comments
                                (
                                    `filename` VARCHAR(255) NOT NULL,
                                    `uid` INT UNSIGNED NOT NULL,
                                    `comment` TEXT NOT NULL
                                )";
        $con->exec($Sql_create_comments_table);
        $sql_create_user_table = "CREATE TABLE IF NOT EXISTS $dbname.likes
                                (
                                    `filename` VARCHAR(255) NOT NULL,
                                    `uid` INT UNSIGNED NOT NULL,
                                    `lik` INT UNSIGNED NOT NULL DEFAULT 0
                                )";
        $con->exec($sql_create_user_table);
        $con = NULL;
?>