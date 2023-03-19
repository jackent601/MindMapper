<?php
    session_start();
?>

<?php 
// Function to generate API key
    function getRandomString($n)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
?>

<?php
    /*
    create account API Documentation:

        request to create account, must have unique new username
            strings escaped 
            crucially if create account succesful creates an api key for user

    Return:
        bool: succesful login or not
        redirects to homepage or login dependent

    */
    header("Content-Type: application/json");

    if ($_SERVER['REQUEST_METHOD']==='POST') {
        // Initialise Session variables
        $_SESSION['PASSWORDS_DONT_MATCH'] = false;
        $_SESSION['USERNAME_TAKEN'] = false;
        $_SESSION['NO_PASSWORD'] = false;
        $_SESSION['NO_USERNAME'] = false;


        if (isset($_POST['USER_NAME'])){
            // Check username length
            if(!strlen($_POST['USER_NAME'])>0){
                http_response_code(404);
                echo json_encode(["message" => "No Password provided"]);
                $_SESSION['NO_USERNAME'] = true;
                header('location: ./../../client/createAccount.php');
                exit;
            }
            if (isset($_POST['PASSWORD'])){
                // Check password length
                if(!strlen($_POST['PASSWORD'])>0){
                    http_response_code(404);
                    echo json_encode(["message" => "No Password provided"]);
                    $_SESSION['NO_PASSWORD'] = true;
                    header('location: ./../../client/createAccount.php');
                    exit;
                }
                // Get DB connection
                include "dbconn.php";

                // Get User Name (escaping strings)
                $user_name = $conn->real_escape_string($_POST['USER_NAME']);

                // Get Password (escaping strings)
                $password = $conn->real_escape_string($_POST['PASSWORD']);

                // Get re-entered password
                $re_enter_password = $conn->real_escape_string($_POST['RE_ENTER_PASSWORD']);

                // Check re-entered passwords match
                if(strcmp($password, $re_enter_password)){
                    http_response_code(404);
                    echo $password;
                    echo $re_enter_password;
                    echo json_encode(["message" => "Passwords do not match"]);
                    $_SESSION['PASSWORDS_DONT_MATCH'] = true;
                    header('location: ./../../client/createAccount.php');
                    exit;
                }

                // Check username not already taken
                $credentialCheckSQL = "SELECT * FROM users WHERE username = '$user_name'";
                $credentialCheck = $conn->query($credentialCheckSQL);

                if ($credentialCheck->num_rows > 0) {
                    http_response_code(404);
                    echo json_encode(["message" => "Username Taken"]);
                    $_SESSION['USERNAME_TAKEN'] = true;
                    header('location: ./../../client/createAccount.php');
                    exit;
                }

                // Hash & Salt Password
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $createNewUserSQL = "INSERT INTO users (username, password) VALUES ('$user_name', '$hashed_password');";
                $createNewUser = $conn->query($createNewUserSQL);

                // Create API key for user
                // first get new user id
                $getUserIDSQL = "SELECT * FROM users WHERE username = '$user_name'";
                $getUserID = $conn->query($getUserIDSQL);
                $user_credentials = $getUserID->fetch_assoc();
                $user_id = $user_credentials['id'];

                // Generate & Set API
                $api_key = getRandomString(20);
                $createAPIKeySQL = "INSERT INTO api_keys (user_id, api_key) VALUES ('$user_id', '$api_key');";
                $createAPIKey = $conn->query($createAPIKeySQL);

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
                http_response_code(404);
                echo json_encode(["message" => "No Password provided"]);
                $_SESSION['NO_PASSWORD'] = true;
                header('location: ./../../client/createAccount.php');
                exit;
            }

        }else{
            http_response_code(404);
            echo json_encode(["message" => "No Username provided"]);
            $_SESSION['NO_USERNAME'] = true;
            header('location: ./../../client/createAccount.php');
            exit;
        }
    }else{
        http_response_code(404);
        echo json_encode(["message" => "Unsupported request method"]);
        header('location: ./../../client/createAccount.php');
        exit;
    }