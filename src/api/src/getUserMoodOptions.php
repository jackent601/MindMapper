<?php
    session_start();
?>
<?php
    /*
    getUserMoodOptions API Documentation:

        Returns all Mood 'Options' entries for a specific user, this will consist of 'core' moods and 'custom' moods

        Good example of APi abstracting more complicated database architecture in the back end:
            To allow for 'core' moods and 'custom' moods the database separates these
            To get the name for a particular mood entry need to preform database stitiching 
            database backend needs different tables for 'core' and 'custom' to allow customisation without sacrificing 
            database integrity/hygeine

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

        // Verify API key (only proceeds if valid key), API key included automatically in request header through session
        // sets the $user_id variable if key is valid
        include "verifyApiKeyHeader.php";

        // Read User Mood Entries
        // Build Query combining tables

        $moodQuery = 
        "SELECT * FROM -- wrap results in table to allow ordering by with a union
        (SELECT
        -- Get All Core Moods (including a flag for custom)
        core_moods.name as name, all_moods.id as mood_id, core_moods.arousal as arousal, core_moods.valence as valence,  0 as custom_mood 
        FROM core_moods 
        LEFT JOIN all_moods ON core_moods.id = all_moods.core_mood_id

        -- Get and Join with all Custom Moods (including a flag for custom)
        UNION ALL
        SELECT 
        custom_moods.name as name, all_moods.id as mood_id, custom_moods.arousal as arousal, custom_moods.valence as valence, 1 as custom_mood 
        FROM custom_moods 
        LEFT JOIN all_moods ON custom_moods.id = all_moods.custom_mood_id 
        WHERE custom_moods.user_id = '$user_id') results;";

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