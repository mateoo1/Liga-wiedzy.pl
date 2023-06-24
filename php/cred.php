<?php

require "parameters.php";

// establish connection
$conn = new mysqli($dbHost, $username, $password, $dbName);

// check connection
if ($conn->connect_error) {
    if ($debugMode == TRUE) {
        echo "Connection failed: " . $conn->connect_error;
    } else {
        // do not print errors
    }
    exit();
}

// set character set
$conn->set_charset("utf8");

?>
