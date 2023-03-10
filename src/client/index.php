<?php 
    // Session Required to get api key
    session_start();
    // This will be set at login
    // DEV PURPOSES ONLY
    // $_SESSION["API_KEY"] = "validAPIkeyTest";
    // $_SEESION["USER_NAME"] = "Jackent";
    // $_SESSION['LOGGED_IN'] = true;
?>

<?php 
    // Catch and redirect if not logged in
    if (!isset($_SESSION['LOGGED_IN']) or !$_SESSION['LOGGED_IN']){
        header('location: ./login.php');
    }
?>


<script>
    // Function to show or hide mood entries
    function toggleMoodEntriesDisplay(){
        // Toggle display and button value
        var rows = document.getElementById("hideNewRows");
        var btn = document.getElementById("toggleMoodEntries");
        if (rows.style.display === "none") {
            rows.style.display = "block";
            btn.innerHTML  = "<i>hide</i>";
        } else {
            rows.style.display = "none";
            btn.innerHTML  = "<i>show past moods</i>";
        }
    }
</script>
<script>
    // Function to show or hide mood entry form
    function toggleMoodEntryDisplay(){
        // Toggle display and button value
        var rows = document.getElementById("hideMoodEntryForm");
        var btn = document.getElementById("toggleMoodEntryForm");
        if (rows.style.display === "none") {
            rows.style.display = "block";
            btn.innerHTML  = "<i>hide</i>";
        } else {
            rows.style.display = "none";
            btn.innerHTML  = "<i>log a mood</i>";
        }
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
    <!-- script to display mood -->
    <script src = "./js/utilities.js"></script>
    <script src = "./js/displayMoodEntries.js"></script>
    <!-- script to handle entering moods -->
    <script src = "./js/enterMoodFunctions.js"></script>

    <script>
        // Start page with moods hidden
        $(function(){
            var rows = document.getElementById("hideNewRows");
            var btn = document.getElementById("toggleMoodEntries");
            rows.style.display = "none";
            btn.innerHTML  = "<i>show past moods</i>";
        })

        // Start page with mood entry form hidden
        $(function(){
            var form = document.getElementById("hideMoodEntryForm");
            var btn = document.getElementById("toggleMoodEntryForm");
            form.style.display = "none";
            btn.innerHTML  = "<i>log a mood...</i>";
        })
    </script>

    <script>
        /* 
        If logged in display personalised banner, else request login
        Only if logged in Load and Display Moods if logged in
        (loggedin is a session variable set at login (along with api-key))
        */
        // if(loggedIn_js){
            // Set Banner (if logged in, username will definitely be set)
        console.log("executing");         

        // Load previous Mood to display for this user (user id found from session variable set at login, through api-key verification)
        $.ajax({
            url: "http://localhost/Project/src/api/src/getUserMoodEntriesapi.php",
            beforeSend: function(request) {
                // Setting x-api-key is crucial to access database and find user_id
                request.setRequestHeader("X-API-KEY", "<?php echo $_SESSION['API_KEY']?>");
            },
            type: "GET",
            dataType: "json",
            success: function (res) {
                // Display Cards
                displayMoodEntries(res);
                
                // Add Hover Event to expand mood context
                $('.hoverSwitchParent').hover(
                function () {
                    // Get Child and show
                    $(this).find('.hoverSwitchChild').toggle('show')
                });
            },
            error: function (res) {console.log(res);}}) 

        // Load and Display Moods for this user (user id found from session variable set at login, through api-key verification)
        $.ajax({
            url: "http://localhost/Project/src/api/src/getUserMoodOptionsapi.php",
            beforeSend: function(request) {
                // Setting x-api-key is crucial to access database and find user_id
                request.setRequestHeader("X-API-KEY", "<?php echo $_SESSION['API_KEY']?>");
            },
            type: "GET",
            dataType: "json",
            success: function (res) {
                // Display Cards
                populateMoodOptionsEntryForm(res);
            },
            error: function (res) {console.log(res);}})
        // }else{
            // If Not logged in redirect to login page
            // $(function(){
            //     var banner = "<b>Please Login</b>";
            //     $("#jumbo").append(banner);
            // });   
            // console.log("not logged in");
        // }
        </script>
    </script>
</head>
<body>
    <nav>
        <a href="#" class="brand">
          <img class="logo" src="./media/logo.png"/>
          <span>Mood tracker</span>
        </a>
        
        <input id="bmenub" type="checkbox" class="show">
        <label for="bmenub" class="burger success button">Menu</label>
      
        <div class="menu">
           <a href="#" class="pseudo button">Shop</a>
           <a href="./logout.php" class="pseudo button">Log out</a>
           <a href="./deleteAccount.php" class="pseudo button">Delete Account</a>       
        </div>
    </nav>

    <div id="jumbo">
        <b>Welcome Back <?php echo $_SESSION['USER_NAME'] ?>! </b>
    </div>

    <div class="uk-section uk-background-muted">
        <div class="uk-container uk-align-center">
            <h2 class="uk-heading-small uk-heading-line uk-text-center "><span>Log a Mood</span></h2>
            <button id = "toggleMoodEntryForm" class="expandButton uk-align-center" onclick = "toggleMoodEntryDisplay()"><i>log a mood</i></button>
            <div id="hideMoodEntryForm">
                <form id="newMoodEntryForm">
                    <fieldset class="uk-fieldset">

                        <legend class="uk-legend">Mood Entry</legend>

                        <div class="uk-margin">
                            <h3> Mood </h3>
                            <select id="moodOptionSelectDiv" class="uk-select" aria-label="Select" name = "mood_selection">
                            </select>
                        </div>

                        <div class="uk-margin">
                            <input name = "mood_context" class="uk-input" type="text" placeholder="Conext (optional)" aria-label="Input">
                        </div>

                        <button id="moodEntrySubmit" class="moodEntrySubmit uk-align-center", onclick="handleMoodEntrySubmission(event, '<?php echo $_SESSION['API_KEY']?>')">Log Mood</button>

                    </fieldset>
                </form>
            </div>
        </div>
    </div>

    <div class="uk-section uk-background-muted">
        <div class="uk-container">
            <h3 class="uk-heading-small uk-heading-line uk-text-center "><span>Mood Entries</span></h3>
            <button id = "toggleMoodEntries" class="expandButton uk-align-center" onclick="toggleMoodEntriesDisplay()"><i>show</i></button>
            <!-- <h2 class="uk-heading-small uk-text-left">Mood Entries</h2> -->
                <div id="hideNewRows">
                    <div id="newrows" class="uk-child-width-1-2@s uk-grid-match" uk-grid>
                    </div>
                </div>
        </div>
    </div>

    <div class="uk-section uk-background-muted">
        <div class="uk-container">
            <h3 class="uk-heading-small uk-heading-line uk-text-center "><span>Mood Charts</span></h3>
            <button id = "goToMoodCharts" class="expandButton uk-align-center" onclick="window.location.href='./moodCharts.php';"><i>Go To Charts</i></button>
        </div>
    </div>

</body>
</html>