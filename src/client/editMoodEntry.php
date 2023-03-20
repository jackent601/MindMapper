<?php 
    // Session Required to get api key
    session_start();
    // This will be set at login
    // DEV PURPOSES ONLY
    // $_SESSION["API_KEY"] = "validAPIkeyTest";
    // $_SESSION["USER_NAME"] = "Jackent";
    // $_SESSION['LOGGED_IN'] = true;
    // $_GET['editMoodEntry'] = 4;
?>

<script>
    // Translates PHP variables into js as js more convenient to format document
    var loggedIn_js = 
    <?php 
        if (isset($_SESSION['LOGGED_IN']) and $_SESSION['LOGGED_IN']){
            echo "true"; 
        }else{
            echo "false";
        }
    ?>;
    console.log("<?php if(isset($_GET['editMoodEntry'])){echo "MOOD ID SET";}?>")
    
    var mood_entry_id = 
    <?php 
        if (isset($_GET['editMoodEntry'])){
            echo $_GET['editMoodEntry']; 
        }else{
            echo "'NULL'";
        }
    ?>;
    // Debug
    console.log("Logged in JS: "+loggedIn_js);
    console.log("mood_entry_id: "+mood_entry_id);
</script>


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
    <!-- script to display edit mood form -->
    <script src = "./js/utilities.js"></script>
    <script src = "./js/editAndDeleteMoodEntryFunctions.js"></script>

    <script>
        // User logged in
        if(loggedIn_js){
            // Set Banner
            $(function(){
                var banner = "<b>Welcome Back <?php echo $_SESSION['USER_NAME'] ?> </b>";
                $("#jumbo").append(banner);
            });
            
            // Get Mood To Update
            // Load and Display Mood Entry to edit
            // The load function also assigns appropriate api handling for editing/deleting
            $.ajax({
                url: "http://localhost/Projectv2/mindmapper/src/api/src/getMoodEntryFromIDapi.php?MOOD_ENTRY_ID="+mood_entry_id,
                beforeSend: function(request) {
                    // Setting x-api-key is crucial to access database and find user_id
                    request.setRequestHeader("X-API-KEY", "<?php echo $_SESSION['API_KEY']?>");
                },
                type: "GET",
                dataType: "json",
                // On success display mood entry form
                success: function (res) {
                    // dev - console.log(res);
                    // Display Form
                    displayEditMoodEntryForm(res, "<?php echo $_SESSION["API_KEY"] ?>");
                },
                // On Error, loh error results, display no form
                error: function (res) {console.log("failed");}});

        }else{
            // Set Login Banner
            $(function(){
                var banner = "<b>Please Login</b>";
                $("#jumbo").append(banner);
            });   
        }
        </script>
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
    </div>

    <!-- EDIT MOOD FORM -->
    <div class="uk-section uk-background-muted">
        <div class="uk-container">
            <h2 class="uk-heading-small uk-text-left">Edit Mood Entry</h2>
            <div>
                <div id = "editMoodEntryForm" class='uk-card uk-card-body uk-card-hover uk-card-default'>
                </div>
        </div>
    </div>

</body>
</html>