<?php

/*
    Register (insert) student. 

    API call is made using POST to this script.
*/

    // Required headers
    // First line allows API calls from any address
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");

    // Include database and object files
    include_once "../Config/database.php";
    include_once "../Objects/student.php";
    
    // Instantiate database
    $database = new Database();
    $db = $database->getConnection();
    
    // Initialize student object
    $student = new student($db);

    // Get data sent from front-end
    // php://input includes body data sent using POST
    // file_get_contents reads parameter into one string
    // json_decode converts json string to php variable
    $data = json_decode(file_get_contents("php://input"));

    // Check that data is not missing any info
    if (!empty($data->firstName) &&
        !empty($data->lastName) &&
        !empty($data->birthday) &&
        !empty($data->sex) &&
        !empty($data->email) &&
        !empty($data->password)) {

        // Set values in student.php
        $student->s_fname       = $data->firstName;
        $student->s_lname       = $data->lastName;
        $student->s_bdate       = $data->birthday;
        $student->s_sex         = $data->sex;
        $student->s_email       = $data->email;
        $student->s_password    = $data->password;

        // Create student record
        // Successful creation returns true
        if ($student->register()) {

            // HTTP status code - 201 Created
            http_response_code(201);

            echo json_encode(array("Success" => "User Created"));
        }
        // Request failed
        else {

            // HTTP status code - 400 Bad Request
            http_response_code(400);

            echo json_encode(array("Message" => "User Already Exists"));
        }
    }
    // Data missing
    else {

        // HTTP status code - 400 Bad Request
        http_response_code(400);

        echo json_encode(array("Message" => "Bad Request. Incomplete Data"));
    }
?>