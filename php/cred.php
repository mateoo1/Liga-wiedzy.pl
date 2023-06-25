<?php

require "./parameters.php";

// establish connection
$dsn = "mysql:host=$dbHost;dbname=$dbName;charset=utf8";
    
try {
    
    $db = new PDO($dsn, $username, $password, [
        PDO::ATTR_EMULATE_PREPARES => false, 
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
        ]);
                
    } catch (PDOException $error) {
        if ($debugMode == TRUE) {
            echo $error; 
        } else {
            //do not print errors
        }
    exit();
    }
?>
