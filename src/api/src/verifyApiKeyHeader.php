
<?php
    /*
    Checks the API-key provided in a request header, exits if not provided or invalid, passes if valid
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
    
    if ($apiCheck->num_rows <= 0) {
        http_response_code(404);
        echo json_encode(["message" => "Invalid API key provided"]);
        exit;
    }

    if ($_SERVER['PHP_SELf'] = "/project/src/api/src/verifyApiKeyHeader.php"){
        // verify api key visited directly, hence only an api check
        http_response_code(202);
        echo json_encode(["message" => "Valid API key provided"]);
        exit;
    }else{
        // Not visited directly hence used as a utility elsewhere so pass
    }
?>