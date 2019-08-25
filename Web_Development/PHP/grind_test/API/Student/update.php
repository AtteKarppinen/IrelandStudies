<?php

/*
    Student update. Requires token.

    API call is made using PUT to this script.
*/

    // Required headers
    // First line allows API calls from any address
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");

    // JSON Web Token
    // include_once "../Config/core.php";
    // include_once "../Libraries/php-jwt-master/src/BeforeValidException.php";
    // include_once "../Libraries/php-jwt-master/src/ExpiredException.php";
    // include_once "../Libraries/php-jwt-master/src/SignatureInvalidException.php";
    // include_once "../Libraries/php-jwt-master/src/JWT.php";
    // use \Firebase\JWT\JWT;
    include_once "../Objects/token.php";
    $tokenObject = new Token();

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

    // Get JWT. ? operator is called ternary operator
    // (condition) ? happens if true : happens if false
    $jwt = isset($data->token) ? $data->token : "";

    // Check JWT is not empty
    if ($jwt) {

        try {

            // Decode JWT
            // $decoded = JWT::decode($jwt, $key, array("HS256"));
            $decoded = $tokenObject->decodeToken($jwt);

            // Check that data is not missing any info
            if (!empty($data->studentID) &&
                !empty($data->firstName) &&
                !empty($data->lastName) &&
                !empty($data->birthday) &&
                !empty($data->sex) &&
                !empty($data->email) &&
                !empty($data->password)) {

                // Set values in student.php
                $student->s_num         = $data->studentID;
                $student->s_fname       = $data->firstName;
                $student->s_lname       = $data->lastName;
                $student->s_bdate       = $data->birthday;
                $student->s_sex         = $data->sex;
                $student->s_email       = $data->email;
                $student->s_password    = $data->password;

                // SUCCESSFUL UPDATE
                if ($student->update()) {

                    // Fetch newly created user's id
                    $studentID = $student->fetchID();

                    // Regenerate token, payload may have changed (if needed on Front-end)
                    // $tokenPayload = array(
                    //     "exp" => $expiration,
                    //     "data" => array(
                    //         "UserID" => $studentID
                    //     )
                    // );

                    // Create JWT
                    // $jwt = JWT::encode($tokenPayload, $key);

                    $jwt = $tokenObject->createToken($studentID);

                    // HTTP status code - 200 OK
                    http_response_code(200);

                    echo json_encode(
                        array(
                            "Success" => "User Updated",
                            "Token" => $jwt
                        )
                    );
                }
                // Update failed
                else {

                    // HTTP status code - 500 Internal Server Error
                    http_response_code(500);

                    echo json_encode(array("Message" => "Update Failed"));
                }
            }
            // Missing Data
            else {

                // HTTP status code - 400 Bad Request
                http_response_code(400);

                echo json_encode(array("Message" => "Bad Request. Incomplete Data"));
            }
        }
        // JWT decode failed
        catch (Exception $e) {

            // HTTP status code - 401 Unauthorized
            http_response_code(401);

            echo json_encode(array(
                "Message" => "Access Denied",
                "Error" => $e->getMessage()
            ));
        }

    }
    // Jwt not provided
    else {

        // HTTP status code - 401 Unauthorized
        http_response_code(401);

        echo json_encode(array("Message" => "Access Denied"));
    }
?>