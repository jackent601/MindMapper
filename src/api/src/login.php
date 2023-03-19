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

                // Get unsalted unashed Password (escaping strings)
                $password = $conn->real_escape_string($_POST['PASSWORD']);

                // Check user exists
                $credentialCheckSQL = "SELECT * FROM users WHERE username = '$user_name'";
                $credentialCheck = $conn->query($credentialCheckSQL);

                // Check validity
                if ($credentialCheck->num_rows <= 0) {
                    http_response_code(404);
                    echo json_encode(["message" => "Invalid credentials"]);
                    $_SESSION['INVALID_CREDENTIALS'] = true;
                    header('location: ./../../client/login.php');
                    exit;
                }
                if ($credentialCheck->num_rows > 1) {
                    http_response_code(404);
                    echo json_encode(["message" => "Multiple valid credentials found, database integrity compromised!"]);
                    $_SESSION['INVALID_CREDENTIALS'] = true;
                    header('location: ./../../client/login.php');
                    exit;
                }

                // User exists, get salted & hashed password
                $user_credentials = $credentialCheck->fetch_assoc();
                $hashed_password = $user_credentials['password'];

                if(password_verify($password, $hashed_password)) {
                    // Valid password get api key for session
                    $user_id = $user_credentials['id'];
                    $apiKeyCheckSQL = "SELECT * FROM api_keys WHERE user_id = '$user_id'";
                    $apiKeyCheck = $conn->query($apiKeyCheckSQL);
                    // Check validity
                    if ($apiKeyCheck->num_rows <= 0) {
                        http_response_code(404);
                        echo json_encode(["message" => "No API key for user!"]);
                        $_SESSION['INVALID_CREDENTIALS'] = true;                    
                        header('location: ./../../client/login.php');
                        exit;
                    }
                    if ($apiKeyCheck->num_rows > 1) {
                        http_response_code(404);
                        echo json_encode(["message" => "Multiple api keys for user, database integrity compromised!"]);
                        $_SESSION['INVALID_CREDENTIALS'] = true;
                        header('location: ./../../client/login.php');
                        exit;
                    }
                    // API KEY FOUND, unpack
                    $apiKeyValues = $apiKeyCheck->fetch_assoc();
                    $api_key = $apiKeyValues['api_key'];
                    
                    // SET SESSION VARIABLES - IMPORTANT!
                    $_SESSION["API_KEY"] = $api_key;
                    $_SESSION['USER_NAME'] = $user_name;
                    $_SESSION['LOGGED_IN'] = true;
                    $_SESSION['INVALID_CREDENTIALS'] = false;

                    // Redirect to homepage
                    http_response_code(200);
                    header('location: ./../../client/index.php');
                    exit;
                }else{
                    // Invalid password
                    http_response_code(404);
                    echo json_encode(["message" => "Invalid Password provided"]);
                    $_SESSION['INVALID_CREDENTIALS'] = true;
                    header('location: ./../../client/login.php');
                    exit;

                }
            }else{
                http_response_code(404);
                echo json_encode(["message" => "No Password provided"]);
                $_SESSION['INVALID_CREDENTIALS'] = true;
                header('location: ./../../client/login.php');
                exit;
            }

        }else{
            http_response_code(404);
            echo json_encode(["message" => "No Username provided"]);
            $_SESSION['INVALID_CREDENTIALS'] = true;
            header('location: ./../../client/login.php');
            exit;
        }
    }else{
        http_response_code(404);
        echo json_encode(["message" => "Unsupported request method"]);
        $_SESSION['INVALID_CREDENTIALS'] = true;
        header('location: ./../../client/login.php');
        exit;
    }