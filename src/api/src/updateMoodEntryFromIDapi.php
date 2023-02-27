<?php
    session_start();
?>
<?php
    /*
    updateMoodEntryFromIDapi API Documentation:

        Updates a single mood entry based on the mood id provided

    Return:
        bool: succesful delete or not
        redirects to homepage

    */
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD']==='POST') {
        if (isset($_POST['MOOD_ENTRY_ID'])){
            if (isset($_POST['MOOD_CONTEXT_UPDATE'])){
                $mood_entry_id = $_POST['MOOD_ENTRY_ID'];
                $new_mood_context = $_POST['MOOD_CONTEXT_UPDATE'];
            
                // Verify API key (see documentation)
                include "verifyApiKeyHeader.php";

                // Catch escape strings
                $new_mood_context = $conn->real_escape_string($new_mood_context);
    
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
    
                // update mood entry
                $updateEntryQuery = "UPDATE mood_entry SET context='$new_mood_context' WHERE id='$mood_entry_id';";
                $updated = $conn->query($updateEntryQuery);
    
                if ($updated){
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
                echo json_encode(["message" => "No Mood Context Update provided"]);
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