<?php
    session_start();
?>
<?php
    /*
    login API Documentation:

        request to login, must have valid credentials
            strings escaped 
            crucially if login succesful sets session variables used to access api in subsequent mood browsing

    Return:
        bool: succesful login or not
        redirects to homepage or login dependent

    */
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD']==='POST') {
        if (isset($_POST['USER_NAME'])){
            if (isset($_POST['PASSWORD'])){
                // Get DB connection
                include "dbconn.php";

                // Get User Name (escaping strings)
                $user_name = $conn->real_escape_string($_POST['USER_NAME']);

                // Get Password (escaping strings)
                $password = $conn->real_escape_string($_POST['PASSWORD']);

                // Check user exists
                $credentialCheckSQL = "SELECT * FROM users WHERE username = '$user_name' AND password = '$password'";
                $credentialCheck = $conn->query($credentialCheckSQL);

                // Check validity
                if ($credentialCheck->num_rows <= 0) {
                    http_response_code(404);
                    echo json_encode(["message" => "Invalid credentials"]);
                    exit;
                }
                if ($credentialCheck->num_rows > 1) {
                    http_response_code(404);
                    echo json_encode(["message" => "Multiple valid credentials found, database integrity compromised!"]);
                    exit;
                }

                // Valid User Unpack credentials
                $user_credentials = $credentialCheck->fetch_assoc();
                $user_id = $user_credentials['id'];

                // Valid credentials get api key for session
                $apiKeyCheckSQL = "SELECT * FROM api_keys WHERE user_id = '$user_id'";
                $apiKeyCheck = $conn->query($apiKeyCheckSQL);
                // Check validity
                if ($apiKeyCheck->num_rows <= 0) {
                    http_response_code(404);
                    echo json_encode(["message" => "No API key for user!"]);
                    exit;
                }
                if ($apiKeyCheck->num_rows > 1) {
                    http_response_code(404);
                    echo json_encode(["message" => "Multiple api keys for user, database integrity compromised!"]);
                    exit;
                }
                // API KEY FOUND, unpack
                $apiKeyValues = $apiKeyCheck->fetch_assoc();
                $api_key = $apiKeyValues['api_key'];
                
                // SET SESSION VARIABLES - IMPORTANT!
                $_SESSION["API_KEY"] = $api_key;
                $_SESSION['LOGGED_IN'] = true;

                // Login API Testing
                if ($_SERVER['PHP_SELF'] === "/project/src/api/src/login.php"){
                    // login api key visited directly, hence only an api check
                    http_response_code(202);
                    echo json_encode(["message" => "API check: Valid Credentials provided and valid API key found",
                    "user_name" => $user_name,
                    "password" => $password,
                    "user_id" => $user_id,
                    "user_api_key" => $api_key]);
                    exit;
                }else{
                    // Not visited directly hence used as a utility so pass
                }
            }else{
                http_response_code(404);
                echo json_encode(["message" => "No Password provided"]);
            }

        }else{
            http_response_code(404);
            echo json_encode(["message" => "No Username provided"]);
        }
    }else{
        http_response_code(404);
        echo json_encode(["message" => "Unsupported request method"]);
        exit;
    }