<?php


// foreach (getallheaders() as $name => $value) {
//     echo nl2br("$name: $value\n");
// }
// $headers = getallheaders();
// echo nl2br("\n");
// echo nl2br("\n");
// echo $headers["Accept-Encoding"];

// http_response_code(200);
// echo $response;


?>

<?php
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD']==='GET') {

        // Check api key provided
        if (!in_array("X-API-KEY", array_keys(getallheaders()))){
            http_response_code(404);
            echo json_encode(["message" => "No API key provided","headers_provided" => getallheaders()]);
            exit;
        }

        $requestHeaders = getallheaders();
        $api_key = $requestHeaders["X-API-KEY"];
        // if (!$api_key){
        //     http_response_code(404);
        //     echo json_encode(["message" => "No API key provided"]);
        //     exit;
        // } 
        
        // Check api key (this will be used a lot, maybe functionalise?)
        include "dbconn.php";
        $apiCheckSQL = "SELECT * FROM api_keys WHERE api_key = '$api_key'";
        $apiCheck = $conn->query($apiCheckSQL);

        if (!$apiCheck) {
            exit($conn->error);
        }
        
        if ($apiCheck->num_rows > 0) {
            http_response_code(200);
            echo json_encode(["message" => "Valid API key provided"]);
        }
        
        else {
            http_response_code(404);
            echo json_encode(["message" => "Invalid API key provided"]);
        }
        
        // include "dbconn.php";
        // $readSQL = "SELECT * FROM runschedule";
        // $result = $conn->query($readSQL);

        // if (!$result) {
        //     exit($conn->error);
        // }

        // // build a response array
        // $api_response = array();
        // while ($row = $result->fetch_assoc()) {
        //     array_push($api_response, $row);
        // }
        // // encode the response as JSON
        // $response = json_encode($api_response);

        // // echo out the response
        // if ($response != false) {
        //     http_response_code(200);
        //     echo $response;
        // } else {
        //     http_response_code(404);
        //     echo json_encode(["message" => "Unable to process response!"]);
        // }
    }