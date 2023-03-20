<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "mindtrial";

    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        exit($conn->connect_error);
    }
?>

