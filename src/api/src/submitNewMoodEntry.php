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
        if (isset($_POST['NEW_ENTRY_MOOD_NAME'])){
            if(isset($_POST['NEW_ENTRY_MOOD_VALENCE'])){
                if(isset($_POST['NEW_ENTRY_MOOD_AROUSAL'])){
                    // Unpack entry
                    $name = $_POST['NEW_ENTRY_MOOD_CONTEXT'];
                    $valence = $_POST['NEW_ENTRY_MOOD_VALENCE'];
                    $arousal = $_POST['NEW_ENTRY_MOOD_AROUSAL'];

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

                    // add entry (using current timestamp)
                    $moodEntryQuery = "INSERT INTO mood_entry (user_id, context, datetime, name, valence, arousal)
                    VALUES ('$user_id', '$mood_context', CURRENT_TIMESTAMP, '$name', '$valence', '$arousal');";
                    $moodEntered = $conn->query($moodEntryQuery);

                    if ($moodEntered){
                        // Successful deletion, redirect to homepage
                        http_response_code(200);
                        echo json_encode(["Mood Entered" => $moodEntered]);
                        exit;
                    }else{
                        http_response_code(404);
                        echo json_encode(["message" => "Error in database connection"]);
                        exit($conn->error);
                    }

                }else{
                    http_response_code(404);
                    echo json_encode(["message" => "No Mood arousal provided"]);
                }

            }else{
                http_response_code(404);
                echo json_encode(["message" => "No Mood Valence provided"]);
            }

        }else{
            http_response_code(404);
            echo json_encode(["message" => "No Mood Name provided"]);
        }
    }else{
        http_response_code(404);
        echo json_encode(["message" => "Unsupported request method"]);
        exit;
    }