<?php

/*
    Student log in. Send token with success message.

    API call is made using POST to this script.
*/
    session_start();

    // Required headers
    // First line allows API calls from any address
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");

    // Include database and object files and token
    include_once "../Config/database.php";
    include_once "../Objects/student.php";
    include_once "../Objects/token.php";
    
    // Instantiate database
    $database = new Database();
    $db = $database->getConnection();
    
    // Initialize student object
    $student = new student($db);

    // JSON Web Token class
    $tokenObject = new Token();

    // Get data sent from front-end
    // php://input includes body data sent using POST
    // file_get_contents reads parameter into one string
    // json_decode converts json string to php variable
    $data = json_decode(file_get_contents("php://input"));

    // Check that data is not missing any info
    if (!empty($data->email) &&
        !empty($data->password)) {

        // Set values in student.php
        $student->s_email       = $data->email;
        $student->s_password    = $data->password;

        // Log in
        // Successful login returns true
        if ($student->login()) {

            // Fetch newly created user's id
            $studentID = $student->fetchID();

            // Create token with user ID in payload
            $token = $tokenObject->createToken($studentID);

            // Create success array
            $successArray["Success"] = array();

            // Populate array with student ID and token
            array_push($successArray["Success"], array("User ID" => $studentID, "Token" => $token));

            // Session variable
            $_SESSION["loggedIn"] = true;

            // HTTP status code - 200 OK
            http_response_code(200);

            echo json_encode($successArray);
        }
        // Request failed
        else {

            // HTTP status code - 401 Unauthorized
            http_response_code(401);

            echo json_encode(array("Message" => "Wrong Email Or Password"));
        }
    }
    // Data missing
    else {

        // HTTP status code - 400 Bad Request
        http_response_code(400);

        echo json_encode(array("Message" => "Bad Request. Incomplete Data"));
    }
?>