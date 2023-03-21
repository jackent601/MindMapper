<?php 
    // Session Required to get api key
    session_start();
    // This will be set at login
    // DEV PURPOSES ONLY
    // $_SESSION["API_KEY"] = "validAPIkeyTest";
    // $_SEESION["USER_NAME"] = "Jackent";
    // $_SESSION['LOGGED_IN'] = true;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mind Mapper Home Page</title>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>    
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.15.12/dist/css/uikit.min.css" />
    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.15.12/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.15.12/dist/js/uikit-icons.min.js"></script>
    <!-- Personal css and picnic -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/picnic">
    <link rel="stylesheet" href="./css/mystyles.css">
</head>
<body>
    <nav>
        <a href="./" class="brand">
          <img class="logo" src="./media/logo.png"/>
          <span>Mind Mapper</span>
        </a>
        
        <input id="bmenub" type="checkbox" class="show">
        <label for="bmenub" class="burger success button">Menu</label>
      
        <div class="menu">
           <a href="./info.php" class="pseudo button">Info</a>
           <?php 
                // Catch and redirect if not logged in
                if (!isset($_SESSION['LOGGED_IN']) or !$_SESSION['LOGGED_IN']){
                    echo "<a href='./login.php' class='pseudo button'>Sign In</a>";  
                }else{
                    echo "<a href='./logout.php' class='pseudo button'>Log out</a>";
                    echo "<a href='./deleteAccount.php' class='pseudo button'>Delete Account</a>"; 
                }
            ?>
           <!-- <a href="./logout.php" class="pseudo button">Log out</a>
           <a href="./deleteAccount.php" class="pseudo button">Delete Account</a>        -->
        </div>
    </nav>

    <div id="jumbo">
        <b>Mind Mapper Info</b>
    </div>

    <div class="uk-section uk-background-muted">
        <div class="uk-container">
            <h3 class="uk-heading-small uk-heading-line uk-text-center "><span>Info </span></h3>

            <div class = "uk-card uk-card uk-card-body uk-align-center">
                <p>Mind Mapper is an application to allow users to track their moods over time</p>
                <p>Moods are captured using a Valence-Arousal circumplex model, more details of the model 
                    can be found <a href="https://en.wikipedia.org/wiki/Emotion_classification#Circumplex_model">here</a>.
                </p>
                <p>Happy Mooding!</p>
            </div>

        </div>
        
    </div>


</body>
</html>