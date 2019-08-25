<?php

/*
    This script is resbonsible for fetching students from 
    database and returning them in json-format.

    Now $student->read() call returns every student, make 
    more functions in objects/student.php for different purposes
    like readBySubject().

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

    // Query students
    $students = $student->fetchAll();
    $num = $students->rowCount();
    
    // Check if more than 0 record found
    if ($num > 0) {
    
        // students array
        $studentsArray["Students"] = array();
    
        // Retrieve our table contents
        while ($row = $students->fetch(PDO::FETCH_ASSOC)) {
            
            // This will make $row["Fname"] to
            // Just $Fname only
            extract($row);
    
            // "Description for data" => student property (fields from db)
            $studentItem=array(
                "Student Number" => $s_num,
                "First Name" => $s_fname,
                "Last Name" => $s_lname,
                "Birthday" => $s_bdate,
                "Sex" => $s_sex,
                "Email" => $s_email,
                "Password" => $s_password,  // TODO: Remove, only for developing purposes
                "Address" => $s_address
                // Location is in unrecognised format, breaking this call
                // "Location" => $Location
            );
            array_push($studentsArray["Students"], $studentItem);
        }
    
        // Set response code - 200 OK
        http_response_code(200);
    
        // Show students data in json format
        echo json_encode($studentsArray);
    }
    else {
    
        // Set response code - 404 Not Found
        http_response_code(404);
    
        // Tell the user no students found
        echo json_encode(
            array("Message" => "No students found.")
        );
    }
?>