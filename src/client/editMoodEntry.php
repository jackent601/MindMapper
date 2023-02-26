<?php 
    // Session Required to get api key
    session_start();
    // This will be set at login
    // DEV PURPOSES ONLY
    $_SESSION["API_KEY"] = "validAPIkeyTest";
    $_SEESION["USER_NAME"] = "Jackent";
    $_SESSION['LOGGED_IN'] = true;
    $_POST['editMoodEntry'] = 4;
?>

<script>
    // Translates PHP variables into js as js more convenient to format document
    var loggedIn_js = 
    <?php 
        if (isset($_SESSION['LOGGED_IN']) && $_SESSION['LOGGED_IN']){
            echo "true"; 
        }else{
            echo "false";
        }
    ?>;
    var mood_entry_id = 
    <?php 
        if (isset($_SESSION['LOGGED_IN']) && isset($_POST['editMoodEntry'])){
            echo $_POST['editMoodEntry']; 
        }else{
            echo "'NULL'";
        }
    ?>;
    // Debug
    console.log("Logged in JS: "+loggedIn_js);
</script>

<script>
    function displayEditMoodEntryForm(moodEntry){
    // Unpack Mood Entry
    var mood_entry_id = moodEntry.id;
    var mood_name = moodEntry.name;
    var mood_desc = moodEntry.descriptor;
    var context = moodEntry.context;
    var datetime = moodEntry.datetime;
    // Format Date
    var datetimeFormatted = getDateStringFromDateTime(datetime);

    // create Form
    var newForm = "<form>"+
    // Mood Date (cant be changed)
    "<fieldset class='uk-fieldset'><legend class='uk-legend'>"+datetimeFormatted+"</legend>"+
    // Mood Value (cant be changed)
    "<div class='uk-margin'><h3> Mood </h3><input class='uk-input uk-form-width-medium' type='text' aria-label='disabled' value='"+ mood_name +"' disabled></div>"+
    // Context (editable)
    "<div class='uk-margin'><h3> Context </h3></div>"+
    "<div class='uk-margin'><input name = 'moodContext' class='uk-input' type='text' value='"+context+"'aria-label='Input'></div>"+
    // Update Buttons
    "<div class='uk-margin uk-grid-small uk-child-width-auto uk-grid'><p class='uk-margin'>"+
        "<button id = 'updateMoodEntry' class='uk-button uk-button-default'>Update</button>"+
        "<button id = 'deleteMoodEntry' class='uk-button uk-button-danger'>Delete</button>"+
    "</p></div></fieldset></form>";

    // Add to DOM
    $("#editMoodEntryForm").append(newForm);
    }
</script>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Tracker Home Page</title>
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
    <script src = "./js/displayMoodEntries.js"></script>

    <script>
        // User logged in
        if(loggedIn_js){
            // Set Banner
            $(function(){
                var banner = "<b>Welcome Back <?php echo $_SEESION['USER_NAME'] ?> </b>";
                $("#jumbo").append(banner);
            });
            
            // Get Mood To Update
            // Load and Display Mood Entry to edit
            $.ajax({
                url: "http://localhost/Project/src/api/src/getMoodEntryFromIDapi.php?MOOD_ENTRY_ID="+mood_entry_id,
                beforeSend: function(request) {
                    // Setting x-api-key is crucial to access database and find user_id
                    request.setRequestHeader("X-API-KEY", "<?php echo $_SESSION['API_KEY']?>");
                },
                type: "GET",
                dataType: "json",
                // On success display mood entry form
                success: function (res) {
                    // 
                    console.log(res);
                    // Display Form
                    displayEditMoodEntryForm(res);
                },
                // On Error, display error form
                error: function (res) {console.log("failed");}});

                // Set Confirmation Event on Delete
                $('#deleteMoodEntry').on('click', function () {
                if(confirm('Are you sure you want to delete this entry?')){
                    console.log("Request to delete mood id:" + $(this).attr('id'));
                }else{
                    console.log("Mood Entry Deletion Aborted");
                }
            });
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
          <span>Mood tracker</span>
        </a>
        
        <input id="bmenub" type="checkbox" class="show">
        <label for="bmenub" class="burger success button">Menu</label>
      
        <div class="menu">
           <a href="#" class="pseudo button">Shop</a>
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
                    <!-- <form>
                        <fieldset class="uk-fieldset">

                            <legend class="uk-legend">Legend</legend>

                            <div class="uk-margin">
                                <input class="uk-input uk-form-width-medium" type="text" placeholder="disabled" aria-label="disabled" value="disabled" disabled>
                            </div>

                            <div class="uk-margin">
                                <h3> Mood Context </h3>
                            </div>

                            <div class="uk-margin">
                                <input name = "moodContext" class="uk-input" type="text" placeholder="Input" aria-label="Input">
                            </div>

                            <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                                <p class="uk-margin">
                                    <button id = "updateMoodEntry" class="uk-button uk-button-default">Update</button>
                                    <button id = "deleteMoodEntry" class="uk-button uk-button-danger">Delete</button>
                                </p>    
                            </div>

                        </fieldset>
                    </form> -->
                </div>
        </div>
    </div>

</body>
</html>