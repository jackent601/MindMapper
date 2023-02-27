<?php
    session_start();
?>
<?php
    /*
    submitNewMoodEntry API Documentation:

        submits a new mood entry 

    Return:
        bool: succesful delete or not
        redirects to homepage

    */
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD']==='POST') {
        if (isset($_POST['NEW_ENTRY_MOOD_ID'])){
            $mood_id = $_POST['NEW_ENTRY_MOOD_ID'];
            
            // Mood context optional
            if(isset($_POST['NEW_ENTRY_MOOD_CONTEXT'])){
                $mood_context = $_POST['NEW_ENTRY_MOOD_CONTEXT'];
            }else{
                $mood_context = "";
            }
            
            
            // Verify API key (see documentation)
            include "verifyApiKeyHeader.php";

            // Catch escaped strings
            $mood_context = $conn->real_escape_string($mood_context);

            // Check Mood ID is valid (could be functionalised)
            $checkIDQuery = "SELECT id FROM all_moods WHERE id='$mood_id';";
            $idCheck = $conn->query($checkIDQuery);
            // Check Not Empty
            if($idCheck->num_rows <= 0){
                http_response_code(404);
                echo json_encode(["message" => "Mood id not found"]);
                exit;
            }
            // Check Database integrity
            if($idCheck->num_rows > 1){
                http_response_code(404);
                echo json_encode(["message" => "Multiple rows for mood ID, database integrity compromised"]);
                exit;
            }

            // Mood valid, add entry (using current timestamp)
            $moodEntryQuery = "INSERT INTO mood_entry (user_id, mood_id, context, datetime)
            VALUES ('$user_id', '$mood_id', '$mood_context', CURRENT_TIMESTAMP);";
            $moodEntered = $conn->query($moodEntryQuery);

            if ($moodEntered){
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
            echo json_encode(["message" => "No Mood id provided"]);
        }
    }else{
        http_response_code(404);
        echo json_encode(["message" => "Unsupported request method"]);
        exit;
    }