<?php
    session_start();
?>
<?php
    /*
    getUserMoodEntries API Documentation:

        Deletes a single mood entry based on the mood id provided

    Return:
        bool: succesful delete or not
        redirects to homepage

    */
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD']==='POST') {
        if (isset($_POST['MOOD_ENTRY_ID'])){
            $mood_entry_id = $_POST['MOOD_ENTRY_ID'];
            
            // Verify API key (see documentation)
            include "verifyApiKeyHeader.php";

            // Check Mood ID is valid (could be functionalised)
            $checkIDQuery = "SELECT id FROM mood_entry WHERE id='$mood_entry_id';";
            $idCheck = $conn->query($checkIDQuery);
            // Check Not Empty
            if($idCheck->num_rows <= 0){
                http_response_code(404);
                echo json_encode(["message" => "No rows for entry, likely invalid mood entry id"]);
                exit;
            }
            // Check Database integrity
            if($idCheck->num_rows > 1){
                http_response_code(404);
                echo json_encode(["message" => "Multiple rows for ID, database integrity compromised"]);
                exit;
            }

            // Mood entry valid, delete entry
            // First need to delete any tag entries (needs done first due to FK restraint)
            $deleteMoodEntryTags = "DELETE FROM mood_entry_user_tags WHERE mood_entry_id='$mood_entry_id';";
            $deletedTags = $conn->query($deleteMoodEntryTags);
            if(!$deletedTags){
                http_response_code(404);
                echo json_encode(["message" => "Error in database connection, could not delete user tags for entry"]);
                exit($conn->error);
            }

            // Next Delete mood entry itself
            $deleteEntryQuery = "DELETE FROM mood_entry WHERE id='$mood_entry_id';";
            $deleted = $conn->query($deleteEntryQuery);

            if ($deleted){
                // Successful deletion, redirect to homepage
                http_response_code(200);
                header("location: http://localhost/project/src/client/index.php");
                exit;
            }else{
                http_response_code(404);
                echo json_encode(["message" => "Error in database connection"]);
                exit($conn->error);
            }

        }else{
            http_response_code(404);
            echo json_encode(["message" => "No Mood Entry id provided"]);
        }
    }else{
        http_response_code(404);
        echo json_encode(["message" => "Unsupported request method"]);
        exit;
    }