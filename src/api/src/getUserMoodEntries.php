<?php
    session_start();
?>
<?php
    /*
    getUserMoodEntries API Documentation:

        Returns all Mood entries for a specific user

    Return:
        array:
            id: 
            user_id:
            mood_id: 
            context: 
            datetime: (ordered descending)

            -- below is from stitching to separate core/custom mood tables --
            name: 
            descriptor: 
            arousal: 
            valence:
            custom_mood: (Flag added in query to identify core vs custom)

    */
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD']==='GET') {

        // Verify API key (only proceeds if valid key), API key included automatically in request header through session
        // sets the $user_id variable if key is valid
        include "verifyApiKeyHeader.php";

        // Read User Mood Entries
        $moodQuery = "SELECT * FROM mood_entry WHERE mood_entry.user_id = '$user_id' ORDER BY datetime DESC;";

        // Fetch Query
        $moodEntries = $conn->query($moodQuery);
        
        if (!$moodEntries) {
            exit($conn->error);
        } 
        
        // build a response array
        $api_response = array();
        foreach ($moodEntries as $row) {
            array_push($api_response, $row);
        }

        // encode the response as JSON
        $response = json_encode($api_response);

        // Send results
        if ($response != false) {
            http_response_code(200);
            echo $response;
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Failed querying Database"]);
        }
    }