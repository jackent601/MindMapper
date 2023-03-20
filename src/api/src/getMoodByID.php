<?php
    session_start();
?>
<?php
    /*
    getUserMoodO by ID API Documentation:

        Returns all Mood either 'core' moods and 'custom' moods

        No need for API verification as mood values themselves are not sensitive


    Return:
        array:
            id: 
            name: 
            descriptor: 
            arousal: 
            valence:
            custom_mood: (Flag added in query to identify core vs custom)

    */
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD']==='GET') {
        if (isset($_GET['MOOD_ID'])){
            include "dbconn.php";

            $mood_id = $_GET['MOOD_ID'];

            // Get Mood
            $moodQuery = "SELECT * FROM all_moods WHERE all_moods.id = '$mood_id';";

            // Fetch Query
            $mood = $conn->query($moodQuery);
            
            if (!$mood) {
                exit($conn->error);
            } 

            // Get results
            $moodResult = $mood->fetch_assoc();
            $custom_id = $moodResult["custom_mood_id"];
            $core_id = $moodResult["core_mood_id"];

            // Return either core or custom value
            if(is_null($custom_id)){
                $coreMoodQuery = "SELECT arousal, valence, name, description  FROM core_moods WHERE id = '$core_id';";
                $coreMood = $conn->query($coreMoodQuery)->fetch_assoc();
                $response = json_encode($coreMood);

            }else{
                $customMoodQuery = "SELECT arousal, valence, name, description FROM custom_moods WHERE id = '$custom_id';";
                $customMood = $conn->query($customMoodQuery)->fetch_assoc();
                $response = json_encode($customMood);

            }

            // Send results
            if ($response != false) {
                http_response_code(200);
                echo $response;
            } else {
                http_response_code(404);
                echo json_encode(["message" => "Failed querying Database"]);
            }
        }else{
            http_response_code(404);
            echo json_encode(["message" => "No Mood ID provided"]); 
        }
    }