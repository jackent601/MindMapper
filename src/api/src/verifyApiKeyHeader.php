
<?php
    /*
    Checks the API-key provided in a request header, exits if not provided or invalid, passes if valid
    Assigns $user_id if key is valid
    */

    header("Content-Type: application/json");
    
    // Check api key provided
    if (!in_array("X-API-KEY", array_keys(getallheaders()))){
        http_response_code(404);
        echo json_encode(["message" => "No API key provided","headers_provided" => getallheaders()]);
        exit;
    }

    $requestHeaders = getallheaders();
    $api_key = $requestHeaders["X-API-KEY"];
    
    // Check api key is valid
    include "dbconn.php";
    
    $apiCheckSQL = "SELECT * FROM api_keys WHERE api_key = '$api_key'";
    $apiCheck = $conn->query($apiCheckSQL);

    if (!$apiCheck) {
        exit($conn->error);
    }
    
    // Check validity
    if ($apiCheck->num_rows <= 0) {
        http_response_code(404);
        echo json_encode(["message" => "Invalid API key provided"]);
        exit;
    }
    if ($apiCheck->num_rows > 1) {
        http_response_code(404);
        echo json_encode(["message" => "Multiple API keys found, database integrity compromised!"]);
        exit;
    }

    // Checks passed, valid api key, get user_id associated with key
    $user_id = $apiCheck->fetch_assoc()["user_id"];

    if ($_SERVER['PHP_SELF'] === "/project/src/api/src/verifyApiKeyHeader.php"){
        // verify api key visited directly, hence only an api check
        http_response_code(202);
        echo json_encode(["message" => "Valid API key provided", "key_owner_user_id" => $user_id]);
        exit;
    }else{
        // Not visited directly hence used as a utility so pass
    }
?>