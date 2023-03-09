<?php
    session_start();

    # Un-set all session variables
    if(isset($_SESSION['INVALID_CREDENTIALS'])){
        unset($_SESSION['INVALID_CREDENTIALS']);
    }
    if(isset($_SESSION["API_KEY"])){
        unset($_SESSION["API_KEY"]);
    }
    if(isset($_SESSION['USER_NAME'])){
        unset($_SESSION['USER_NAME']);
    }
    if(isset($_SESSION['LOGGED_IN'])){
        unset($_SESSION['LOGGED_IN']);
    }

    # Redirect to home page
    header("Location: index.php");
?>
