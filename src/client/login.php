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
    <title>Mind Mapper Login</title>
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
           <a href="#" class="pseudo button">Sign In</a>
           <a href="#" class="pseudo button">Support</a>       
        </div>
    </nav>

    <div id="jumbo">

    <?php 
        // Catch case where account has just been deleted
        if(isset($_SESSION['ACCOUNT_DELETED'])){
            if($_SESSION['ACCOUNT_DELETED']){
                echo "<p>Account Successfully Deleted, hope to see you again soon!</p>";
            }
            unset($_SESSION['ACCOUNT_DELETED']);
        }
    ?>
        
    
    </div>

    <!-- Catch If Invalid Credentials Have Been Passed -->
    <?php 
        if(isset($_SESSION['INVALID_CREDENTIALS'])){
            if($_SESSION['INVALID_CREDENTIALS']){
                echo '<div class="uk-container uk-align-center">';
                echo '<h4 class="invalidCredentials uk-card-title uk-text-center" color = "red"><i color = "red">Please Provide Valid Login Details</i></h4>';
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
                                    <h3 class="uk-card-title uk-text-center">Please Login</h3>
                                    <form 
                                    action="./../api/src/login.php" 
                                    enctype="application/x-www-form-urlencoded"
                                    method = "POST">
                                        <div class="uk-margin">
                                            <div class="uk-inline uk-width-1-1">
                                                <span class="uk-form-icon" uk-icon="icon: mail"></span>
                                                <input name= "USER_NAME" class="uk-input uk-form-large" type="text">
                                            </div>
                                        </div>
                                        <div class="uk-margin">
                                            <div class="uk-inline uk-width-1-1">
                                                <span class="uk-form-icon" uk-icon="icon: lock"></span>
                                                <input name = "PASSWORD" class="uk-input uk-form-large" type="password">	
                                            </div>
                                        </div>
                                        <div class="uk-margin">
                                            <button class="uk-button uk-button-primary uk-button-large uk-width-1-1">Login</button>
                                        </div>
                                        <div class="uk-text-small uk-text-center">
                                            Not registered? <a href="./createAccount.php">Create an account</a>
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