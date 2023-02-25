<?php 
        // Session Required to get api key
        session_start();
        // This will be set at login
        $_SESSION["API_KEY"] = "apitestkeey"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mood Tracker</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/picnic">
    <link rel="stylesheet" href="./css/mystyles.css">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <!-- Load script to display mood -->
    <script src = "./js/displayUserMoodEntries.js"></script>
    <?php
    // Get API Key
    $api_key = $_SESSION["API_KEY"];
    echo "<script>console.log('API KEY: ".$api_key."')</script>";
    ?>
    <script>
        // Load JSON data with AJAX
        // $.ajax({
        //     url: "http://localhost/project/src/api/dummyapi.php",
        //     type: "GET",
        //     dataType: "json",
        //     success: function (res) {displayMovies(res);}})

        // var users = $.ajax({
        //     url: "http://localhost/project/src/api/src/dummyapi.php",
        //     async: false,
        //     dataType: 'json'
        // }).responseJSON;

        // console.log(users) // successfully pulls users

        // Load and Display Moods
        $.ajax({
            url: "http://localhost/project/src/api/src/getUserMoodEntriesapi.php",
            beforeSend: function(request) {
                request.setRequestHeader("X-API-KEY", "<?php echo $_SESSION['API_KEY']?>");
            },
            type: "GET",
            dataType: "json",
            success: function (res) {displayMovies(res);}})
        </script>
    </script>
</head>
<body>
<?php echo "anything" ?>
    <nav>
        <a href="#" class="brand">
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
        <h1>Login</h1>
    </div>

    <div id="container">   
        <div id="dynamic"></div>   
        <div class="flex two three-600 four-1200" id="newrows"></div>
    </div>

</body>
</html>