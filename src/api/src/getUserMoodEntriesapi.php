<?php
    session_start();
?>
<?php
    /*
    getUserMoodEntries API Documentation:

        Returns all Mood entries for a specific user

        Good example of APi abstracting more complicated database architecture in the back end:
            To allow for 'core' moods and 'custom' moods the database separates these
            To get the name for a particular mood entry need to preform database stitiching 
            database backend needs different tables for 'core' and 'custom' to allow customisation without sacrificing 
            database integrity/hygeine

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
        // Build Query combining tables
        $moodQuery = 
        "SELECT * FROM -- wrap results in table to allow ordering by with a union
        (SELECT
        -- Get All Core Moods (including a flag for custom)
        mood_entry.*, 
        core_moods.name as name, core_moods.description as descriptor, core_moods.arousal as arousal, core_moods.valence as valence, 0 as custom_mood 
        FROM mood_entry 
        LEFT JOIN all_moods ON mood_entry.mood_id = all_moods.id 
        LEFT JOIN core_moods ON all_moods.core_mood_id = core_moods.id
        WHERE mood_entry.user_id = '$user_id' AND all_moods.core_mood_id IS NOT NULL

        -- Get and Join with all Custom Moods (including a flag for custom)
        UNION ALL
        SELECT 
        mood_entry.*, 
        custom_moods.name as name, custom_moods.description as descriptor, custom_moods.arousal as arousal, custom_moods.valence as valence, 1 as custom_mood 
        FROM mood_entry 
        LEFT JOIN all_moods ON mood_entry.mood_id = all_moods.id 
        LEFT JOIN custom_moods ON all_moods.custom_mood_id = custom_moods.id
        WHERE mood_entry.user_id = '$user_id' AND all_moods.custom_mood_id IS NOT NULL) results
        -- Finally order descending by date
        ORDER BY datetime DESC;";

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