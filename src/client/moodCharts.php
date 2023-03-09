<?php
// Session Required to get api key
session_start();
// This will be set at login
// DEV PURPOSES ONLY
// $_SESSION["API_KEY"] = "validAPIkeyTest";
// $_SEESION["USER_NAME"] = "Jackent";
// $_SESSION['LOGGED_IN'] = true;
?>

<script>
    // Translates PHP variables into js as js more convenient to format document
    var loggedIn_js =
    <?php
    if (isset($_SESSION['LOGGED_IN']) && $_SESSION['LOGGED_IN']) {
        echo "true";
    } else {
        echo "false";
    }
    ?>;
    // Debug
    console.log("Logged in JS: " + loggedIn_js);
</script>

<!DOCTYPE html>
<html>

<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
    <title>Chart JS Demo</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    <!-- UIkit CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.15.12/dist/css/uikit.min.css" />
    <!-- UIkit JS -->
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.15.12/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.15.12/dist/js/uikit-icons.min.js"></script>
    <!-- Personal css and picnic -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/picnic">
    <link rel="stylesheet" href="./css/mystyles.css">
    <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

    <script src="https://canvasjs.com/assets/script/jquery-1.11.1.min.js"></script>
    <script src="https://canvasjs.com/assets/script/jquery.canvasjs.min.js"></script>
    <!-- Scripts to plot moods -->
    <script src="./js/utilities.js"></script>
    <script src="./js/chartMoodFunctions.js"></script>
    <script>
        var AllResults;
        /* 
        If logged in display personalised banner, else request login
        Only if logged in Load and Display Moods if logged in
        (loggedin is a session variable set at login (along with api-key))
        */
        if (loggedIn_js) {
            // Get moods to chart, not async as want to load immediately            
            $.ajax({
                url: "http://localhost/Project/src/api/src/getUserMoodEntriesapi.php",
                beforeSend: function (request) {
                    // Setting x-api-key is crucial to access database and find user_id
                    request.setRequestHeader("X-API-KEY", "<?php echo $_SESSION['API_KEY'] ?>");
                },
                async: false,
                type: "GET",
                dataType: "json",
                success: function (res) {
                    AllResults = res;
                },
                error: function (res) { console.log("Failed"); }
            })
        }
    </script>

</head>

<body>

    <nav>
        <a href="./" class="brand">
            <img class="logo" src="./media/logo.png" />
            <span>Mood tracker</span>
        </a>

        <input id="bmenub" type="checkbox" class="show">
        <label for="bmenub" class="burger success button">Menu</label>

        <div class="menu">
            <a href="#" class="pseudo button">Shop</a>
            <a href="./logout.php" class="pseudo button">Log out</a>
            <a href="#" class="pseudo button">Support</a>
        </div>
    </nav>

    <div id="jumbo">
        <b> Mood Charts! </b>
    </div>

    <div><button class="expandButton uk-align-center" onclick="location.href='./';"><i>home</i></button></div>

    <section class="section">
        <div class="container">

            <div class="columns is-mobile is-centered">
                <div class="column is-half">
                </div>
            </div>

            <div class="columns is-mobile is-centered">
                <div id="valenceChart" style="height: 370px; width: 100%;"></div>
            </div>


            <div class="columns is-mobile is-centered">
                <div class="column is-half">
                </div>
            </div>

            <div class="columns is-mobile is-centered">
                <div id="arousalChart" style="height: 370px; width: 100%;"></div>
            </div>

        </div>

    </section>

    <script>
        var chartValues = getDateValuesFromMoodEntries(AllResults);

        // Customise Arousal Chart
        var arousalOptions = {
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Arousal Over Time"
            },
            axisX: {
                valueFormatString: "DD MMM YYYY",
            },
            axisY: {
                title: "Arousal",
                minimum: -10,
                maximum: 10
            },
            data: [
                {
                    type: "spline",
                    lineColor: "black",
                    markerColor: "black",
                    dataPoints: chartValues['arousalDataPoints']
                },
                {
                    type: "area",
                    fillOpacity: 0.1,
                    lineThickness: 0,
                    markerType: "none",
                    color: 'red',
                    dataPoints: [
                        { x: chartValues['arousalDataPoints'][0].x, y: -10 },
                        { x: chartValues['arousalDataPoints'][chartValues['arousalDataPoints'].length - 1].x, y: -10 }
                    ]
                },
                {
                    type: "area",
                    fillOpacity: 0.1,
                    lineThickness: 0,
                    markerType: "none",
                    color: 'green',
                    dataPoints: [
                        { x: chartValues['arousalDataPoints'][0].x, y: +10 },
                        { x: chartValues['arousalDataPoints'][chartValues['arousalDataPoints'].length - 1].x, y: +10 }
                    ]
                }
            ]
        };

        // Add Chart
        $("#arousalChart").CanvasJSChart(arousalOptions);

        // Customize Valence Chart
        var valenceOptions = {
            animationEnabled: true,
            theme: "light2",
            title: {
                text: "Valence Over Time"
            },
            axisX: {
                valueFormatString: "DD MMM YYYY",
            },
            axisY: {
                title: "Valence",
                minimum: -10,
                maximum: 10
            },
            data: [
                {
                    type: "spline",
                    lineColor: "black",
                    markerColor: "black",
                    dataPoints: chartValues['valenceDataPoints']
                },
                {
                    type: "area",
                    fillOpacity: 0.1,
                    lineThickness: 0,
                    markerType: "none",
                    color: 'red',
                    dataPoints: [
                        { x: chartValues['valenceDataPoints'][0].x, y: -10 },
                        { x: chartValues['valenceDataPoints'][chartValues['valenceDataPoints'].length - 1].x, y: -10 }
                    ]
                },
                {
                    type: "area",
                    fillOpacity: 0.1,
                    lineThickness: 0,
                    markerType: "none",
                    color: 'green',
                    dataPoints: [
                        { x: chartValues['valenceDataPoints'][0].x, y: +10 },
                        { x: chartValues['valenceDataPoints'][chartValues['valenceDataPoints'].length - 1].x, y: +10 }
                    ]
                }
            ]
        };
        $("#valenceChart").CanvasJSChart(valenceOptions);

    </script>

</body>

</html>