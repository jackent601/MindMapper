<?php 
    // Session Required to get api key
    session_start();
?>

<?php 
    // Catch and redirect if not logged in
    if (!isset($_SESSION['LOGGED_IN']) or !$_SESSION['LOGGED_IN']){
        header('location: ./login.php');
    }
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
            var banner = "<b>We are so sorry to see you leave :(</b>";
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
           <a href="./logout.php" class="pseudo button">Log out</a>
        </div>
    </nav>

    <div id="jumbo">
    </div>



    <div class="uk-section uk-background-muted">
        <div class="uk-container uk-align-center">
                <div class="uk-width-1-1">
                    <div class="uk-container">
                        <div class="uk-grid-margin uk-grid uk-grid-stack" uk-grid>
                            <div class="uk-width-1-1@m">
                                <div class="uk-margin uk-width-large uk-margin-auto uk-card uk-card-default uk-card-body uk-box-shadow-large">
                                    <h3 class="uk-card-title uk-text-center">Are You 100% Sure You wish to delete your account?</h3>
                                    <form 
                                    action="./../api/src/deleteAccount.php" 
                                    enctype="application/x-www-form-urlencoded"
                                    method = "POST">
                                        <div class="uk-margin">
                                            <button class="uk-button uk-button-primary uk-button-large uk-width-1-1">Yes, Delete My Account</button>
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