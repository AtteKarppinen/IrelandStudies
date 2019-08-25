<?php
/*
    Check that sent token is valid
*/

    // Required headers
    // First line allows API calls from any address
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");

    // For decoding JWT
    include_once "../Config/core.php";
    include_once "../Libraries/php-jwt-master/src/BeforeValidException.php";
    include_once "../Libraries/php-jwt-master/src/ExpiredException.php";
    include_once "../Libraries/php-jwt-master/src/SignatureInvalidException.php";
    include_once "../Libraries/php-jwt-master/src/JWT.php";
    use \Firebase\JWT\JWT;

    // Get posted data
    $data = json_decode(file_get_contents("php://input"));
    
    // Get JWT. ? operator is called ternary operator
    // (condition) ? happens if true : happens if false
    $jwt = isset($data->jwt) ? $data->jwt : "";

    // Check JWT is not empty
    if ($jwt) {

        try {

            // Decode JWT
            $decoded = JWT::decode($jwt, $key, array("HS256"));

            // HTTP status code - 200 OK
            http_response_code(200);
    
            echo json_encode(array(
                "Success" => "Access Granted",
                "Data" => $decoded->data
            ));
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
    // JWT not provided
    else {

        // HTTP status code - 401 Unauthorized
        http_response_code(401);

        echo json_encode(array("Message" => "Access Denied"));
    }
?>