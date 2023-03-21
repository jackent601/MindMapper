<?php 
    // Session Required to get api key
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mind Mapper Tracker Login</title>
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>    
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.15.12/dist/css/uikit.min.css" />
    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.15.12/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.15.12/dist/js/uikit-icons.min.js"></script>
    <!-- Personal css and picnic -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/picnic">
    <link rel="stylesheet" href="./css/mystyles.css">
    <!-- script to display mood -->
    <script src = "./js/utilities.js"></script>
    <script src = "./js/displayMoodEntries.js"></script>
    <!-- script to handle entering moods -->
    <script src = "./js/enterMoodFunctions.js"></script>

    <script>
        // Set Log in Banner
        $(function(){
            var banner = "<b>Please Login</b>";
            $("#jumbo").append(banner);
        });   
    </script>
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
           <a href="./" class="pseudo button">Sign In</a>     
        </div>
    </nav>

    <div id="jumbo">
    </div>

    <!-- Catch If Invalid Credentials Have Been Passed -->
    <?php 
        if(isset($_SESSION['USERNAME_TAKEN'])){
            if($_SESSION['USERNAME_TAKEN']){
                echo '<div class="uk-container uk-align-center">';
                echo '<h4 class="invalidCredentials uk-card-title uk-text-center" color = "red"><i color = "red">Username taken</i></h4>';
                echo '</div>';
            }
        }
        if(isset($_SESSION['PASSWORDS_DONT_MATCH'])){
            if($_SESSION['PASSWORDS_DONT_MATCH']){
                echo '<div class="uk-container uk-align-center">';
                echo '<h4 class="invalidCredentials uk-card-title uk-text-center" color = "red"><i color = "red">Passwords dont match</i></h4>';
                echo '</div>';
            }
        }
        if(isset($_SESSION['NO_PASSWORD'])){
            if($_SESSION['NO_PASSWORD']){
                echo '<div class="uk-container uk-align-center">';
                echo '<h4 class="invalidCredentials uk-card-title uk-text-center" color = "red"><i color = "red">Provide a password</i></h4>';
                echo '</div>';
            }
        }
        if(isset($_SESSION['NO_USERNAME'])){
            if($_SESSION['NO_USERNAME']){
                echo '<div class="uk-container uk-align-center">';
                echo '<h4 class="invalidCredentials uk-card-title uk-text-center" color = "red"><i color = "red">Provde a username</i></h4>';
                echo '</div>';
            }
        }
    ?>

    <div class="uk-section uk-background-muted">
        <div class="uk-container uk-align-center">
                <div class="uk-width-1-1">
                    <div class="uk-container">
                        <div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid>
                            <div class="uk-width-1-1@m">
                                <div class="uk-margin uk-width-large uk-margin-auto uk-card uk-card-default uk-card-body uk-box-shadow-large">
                                    <h3 class="uk-card-title uk-text-center">User Name</h3>
                                    <form 
                                    action="./../api/src/createAccount.php" 
                                    enctype="application/x-www-form-urlencoded"
                                    method = "POST">
                                        <div class="uk-margin">
                                            <div class="uk-inline uk-width-1-1">
                                                <span class="uk-form-icon" uk-icon="icon: mail"></span>
                                                <input name= "USER_NAME" class="uk-input uk-form-large" type="text">
                                            </div>
                                        </div>
                                        <h3 class="uk-card-title uk-text-center">Password</h3>
                                        <div class="uk-margin">
                                            <div class="uk-inline uk-width-1-1">
                                                <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                                <input name = "PASSWORD" class="uk-input uk-form-large" type="password">	
                                            </div>
                                        </div>
                                        <h3 class="uk-card-title uk-text-center">Re-enter Password</h3>
                                        <div class="uk-margin">
                                            <div class="uk-inline uk-width-1-1">
                                                <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                                <input name = "RE_ENTER_PASSWORD" class="uk-input uk-form-large" type="password">	
                                            </div>
                                        </div>
                                        <div class="uk-margin">
                                            <button class="uk-button uk-button-primary uk-button-large uk-width-1-1">Create Account</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </div>

</body>
</html>