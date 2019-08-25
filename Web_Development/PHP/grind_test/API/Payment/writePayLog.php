<?php

/*
    Make (insert) payment. 

    API call is made using POST to this script.
*/

    // Required headers
    // First line allows API calls from any address
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");

    // Include database and object files
    include_once "../Config/database.php";
    include_once "../Objects/payment.php";
    
    // Instantiate database
    $database = new Database();
    $db = $database->getConnection();
    
    // Initialize payment object
    $payment = new payment($db);

    // Get data sent from front-end
    // php://input includes body data sent using POST
    // file_get_contents reads parameter into one string
    // json_decode converts json string to php variable
    $data = json_decode(file_get_contents("php://input"));

    // Check that data is not missing any info
    if (!empty($data->contractNumber) &&
        !empty($data->date) &&
        !empty($data->price)&&
        !empty($data->cardNumber)) {
        
        // Set values in payment.php
        $payment->p_contract_num = $data->contractNumber;
        $payment->p_date = $data->date;
        $payment->p_price   = $data->price;
        $payment->p_card_num = $data->cardNumber;


        // Create payment record
        // Successful creation returns true
        if ($payment->writePayLog()) {

            // HTTP status code - 201 Created
            http_response_code(201);

            echo json_encode(array("Success" => "PayLog Created"));
        }
        // Request failed
        else {

            // HTTP status code - 400 Bad Request
            http_response_code(400);

            echo json_encode(array("Message" => "Make PayLog failed"));
        }
    }
    // Data missing
    else {

        // HTTP status code - 400 Bad Request
        http_response_code(400);

        echo json_encode(array("Message" => "Bad Request. Incomplete Data"));
    }
?>