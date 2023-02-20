<?php
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD']==='GET') {
        
        include "dbconn.php";
        $readSQL = "SELECT * FROM users";
        $result = $conn->query($readSQL);

        if (!$result) {
            exit($conn->error);
        }

        // build a response array
        $api_response = array();
        while ($row = $result->fetch_assoc()) {
            array_push($api_response, $row);
        }
        // encode the response as JSON
        $response = json_encode($api_response);

        // echo out the response
        if ($response != false) {
            http_response_code(200);
            echo $response;
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Unable to process response!"]);
        }
    }

    // if (($_SERVER['REQUEST_METHOD']==='POST') && (isset($_GET['addschedule']))){
    //     http_response_code(200);
    //     echo json_encode(["message" => "POST addschedule requested"]);

    //     include "dbconn.php";

    //     parse_str(file_get_contents('php://input'), $_DATA);

    //     $details = $conn->real_escape_string($_DATA['new_details']);
    //     $date = $_DATA['new_date'];
    //     $insertSQL = "INSERT INTO runschedule (items, mydate) VALUES ('$details', '$date')";
    //     $result = $conn->query($insertSQL);

    //     if (!$result) {
    //         http_response_code(400);
    //         exit($conn->error);
    //     } else {
    //         http_response_code(201);
    //         $last_id = $conn->insert_id;
    //         echo json_encode(["message" => "New schedule successfully added to database with id = $last_id"]);
    //     }
    // } 
       
?>