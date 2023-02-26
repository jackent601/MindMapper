<?php
    session_start();
?>
<?php
    /*
    getUserMoodEntries API Documentation:

        Returns a single mood entry based on the mood id provided - see getUserMoodEntries for joining mood ids to mood details

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
        if (isset($_GET['MOOD_ENTRY_ID'])){
            $mood_entry_id = $_GET['MOOD_ENTRY_ID'];
            // Verify API key (see documentation)
            include "verifyApiKeyHeader.php";

            // Read Mood Entries Build Query joining mood id to mood details
            $moodQuery = 
            "SELECT * FROM -- wrap results in table to allow filtering on id
            (SELECT
            -- Get All Core Moods (including a flag for custom)
            mood_entry.*, 
            core_moods.name as name, core_moods.description as descriptor, core_moods.arousal as arousal, core_moods.valence as valence, 0 as custom_mood 
            FROM mood_entry 
            LEFT JOIN all_moods ON mood_entry.mood_id = all_moods.id 
            LEFT JOIN core_moods ON all_moods.core_mood_id = core_moods.id
            WHERE mood_entry.id = '$mood_entry_id' AND all_moods.core_mood_id IS NOT NULL

            -- Get and Join with all Custom Moods (including a flag for custom)
            UNION ALL
            SELECT 
            mood_entry.*, 
            custom_moods.name as name, custom_moods.description as descriptor, custom_moods.arousal as arousal, custom_moods.valence as valence, 1 as custom_mood 
            FROM mood_entry 
            LEFT JOIN all_moods ON mood_entry.mood_id = all_moods.id 
            LEFT JOIN custom_moods ON all_moods.custom_mood_id = custom_moods.id
            WHERE mood_entry.id = '$mood_entry_id' AND all_moods.custom_mood_id IS NOT NULL) results";

            // Fetch Query
            $moodEntry = $conn->query($moodQuery);
            
            if (!$moodEntry) {
                exit($conn->error);
            } 

            // Check Not Empty
            if($moodEntry->num_rows <= 0){
                http_response_code(404);
                echo json_encode(["message" => "No rows for entry, likely invalid mood entry id"]);
                exit;
            }

            // Check Database integrity
            if($moodEntry->num_rows > 1){
                http_response_code(404);
                echo json_encode(["message" => "Multiple rows for ID, database integrity compromised"]);
                exit;
            }
            
            // Return single row (checks above)
            $api_response = $moodEntry->fetch_assoc();

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

        }else{
            http_response_code(404);
            echo json_encode(["message" => "No Mood Entry id provided"]);
        }
    }