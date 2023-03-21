<?php
    session_start();
?>

<?php
    function getSQL_IN_stringFromQuery($query)
    // Column of interest must be 'id'
    {
        // Note starts with an empty value to allow case of 0 rows to still be used
        $SQL_IN_string = "(''";

        while($row = $query->fetch_assoc()){
            $this_id = $row['id'];
            $SQL_IN_string .= ", '$this_id'";
        }

        $SQL_IN_string .= ")";

        return $SQL_IN_string;

    } 
?>

<?php
    /*
    Delete Account API Documentation:

        request to delete account, must be logged in

        unlike previous api implementations this uses the session variables for authentication. This is to ensure accounts
        can only be deleted through active sessions which have had password authentication. Other api end-points did not need constructed
        in this way instead required session-agnostic implemenations. 

    Return:

    */
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD']==='POST') {

        // Check session variables are set - i.e. valid session
        if (isset($_SESSION['LOGGED_IN']) && isset($_SESSION['API_KEY']) && isset($_SESSION['USER_NAME'])){
            
            // Check logged in
            if ($_SESSION['LOGGED_IN']){

                // Get DB connection
                include "dbconn.php";

                // Get user id from api key
                $api_key = $_SESSION['API_KEY'];
                $user_id = $conn->query("SELECT * FROM api_keys WHERE api_key = '$api_key'")->fetch_assoc()["user_id"];

                // =====================================================================================================
                // Delete Mood Entry Information (including mood tags)
                // =====================================================================================================
                // Get all mood entries for this ID (Need to first get ids to delete entries in M-M MoodEntry-Tag table)
                $mood_entry_ids = $conn->query("SELECT id FROM mood_entry WHERE user_id = '$user_id';");
                $mood_entry_ids_IN_string = getSQL_IN_stringFromQuery($mood_entry_ids);

                // Get all user tags for this ID (Need to first get ids to delete entries in M-M MoodEntry-Tag table)
                $user_tag_ids = $conn->query("SELECT id FROM user_tags WHERE user_id = '$user_id';");
                $user_tag_ids_IN_string = getSQL_IN_stringFromQuery($user_tag_ids);

                // Delete all mood_entry_user_tags (delete entries in M-M MoodEntry-Tag table)
                $delete_mood_entry_user_tags = $conn->query("DELETE FROM mood_entry_user_tags 
                WHERE mood_entry_id IN $mood_entry_ids_IN_string 
                OR user_tag_id IN $user_tag_ids_IN_string;");

                // Delete all mood entries for this id (now no FK constraint errors from M-M table)
                $delete_mood_entry_ids = $conn->query("DELETE FROM mood_entry WHERE user_id = '$user_id';");

                // Delete all user tags for this id (now no FK constraint errors from M-M table)
                $delete_user_tag_ids = $conn->query("DELETE FROM user_tags WHERE user_id = '$user_id';");

                // =====================================================================================================
                // Delete Custom Mood Information
                // =====================================================================================================
                // Get all custom moods for this user
                $custom_mood_ids = $conn->query("SELECT id FROM custom_moods WHERE user_id = '$user_id';");
                $custom_mood_ids_IN_string = getSQL_IN_stringFromQuery($custom_mood_ids);

                // Debug
                // echo "Custom Mood IDs: \n";
                // echo $custom_mood_ids_IN_string; echo "\n";

                // Delete custom moods from all moods table
                $delete_custom_mood_in_moods = $conn->query("DELETE FROM all_moods WHERE custom_mood_id IN $custom_mood_ids_IN_string;");

                // Delete custom moods from custom moods table
                $delete_custom_mood_ids = $conn->query("DELETE FROM custom_moods WHERE user_id = '$user_id';");

                // =====================================================================================================
                // Delete API Information
                // =====================================================================================================

                // All api keys for this user
                $delete_api_from_key = $conn->query("DELETE FROM api_keys WHERE api_key = '$api_key'");
                $delete_api_from_user_id = $conn->query("DELETE FROM api_keys WHERE user_id = '$user_id'");

                // =====================================================================================================
                // Delete API Information
                // =====================================================================================================
                $delete_user = $conn->query("DELETE FROM users WHERE id = '$user_id'");

                http_response_code(200);

                // Un-set all session variables
                unset($_SESSION["API_KEY"]);
                unset($_SESSION['USER_NAME']);
                unset($_SESSION['LOGGED_IN']);

                // Redirect to home page
                $_SESSION['ACCOUNT_DELETED'] = True;
                echo json_encode(["message" => "Account Deleted"]);
                header('location: ./../../client/index.php');


            }else{
                http_response_code(404);
                echo json_encode(["message" => "Must login to delete accounts"]);
                header('location: ./../../client/deleteAccount.php');
                exit;
            }

        }else{
            http_response_code(404);
            echo json_encode(["message" => "Must login to delete accounts"]);
            header('location: ./../../client/deleteAccount.php');
            exit;
        }
    }else{
        http_response_code(404);
        echo json_encode(["message" => "Unsupported request method"]);
        // header('location: ./../../client/deleteAccount.php');
        exit;
    }