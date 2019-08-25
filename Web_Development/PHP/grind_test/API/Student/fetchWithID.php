<?php

/*
    This script is resbonsible for fetching a student from 
    database and returning it in json-format.

    API call now is made using GET to this script.
*/

    // Required headers
    // First line allows API calls from any address
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: GET");

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
    // TODO expect token as well
    if (!empty($data->studentID)) {

        // Set values in student.php
        $student->s_num = $data->studentID;

        // Query student with ID
        $foundStudent = $student->fetchWithID();
        $num = $foundStudent->rowCount();
        
        // Check if more than 0 record found
        if ($num > 0) {
        
            // Retrieve student record
            $row = $foundStudent->fetch(PDO::FETCH_ASSOC);
                
            // This will make $row["Fname"] to
            // Just $Fname only
            extract($row);

            // "Description for data" => student property (fields from db)
            $studentArray=array(
                "Student Number" => $s_num,
                "First Name" => $s_fname,
                "Last Name" => $s_lname,
                "Birthday" => $s_bdate,
                "Sex" => $s_sex,
                "Email" => $s_email,
            );
        
            // Set response code - 200 OK
            http_response_code(200);
        
            // Show students data in json format
            echo json_encode($studentArray);
        }
        else {
        
            // Set response code - 404 Not Found
            http_response_code(404);
        
            // Tell the user no students found
            echo json_encode(
                array("Message" => "No student found.")
            );
        }
    }
    // Missing student ID
    else {

        // HTTP status code - 400 Bad Request
        http_response_code(400);

        echo json_encode(array("Message" => "Bad Request. Incomplete Data"));
    }
?>