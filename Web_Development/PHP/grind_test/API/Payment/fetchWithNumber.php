<?php

/*
    This script is resbonsible for fetching a payment from 
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
    // TODO expect token as well
    if (!empty($data->paymentNumber)) {

        // Set values in payment.php
        $payment->p_num = $data->paymentNumber;

        // Query payment with Number
        $foundPayment = $payment->fetchWithNumber();
        $num = $foundPayment->rowCount();
        
        // Check if more than 0 record found
        if ($num > 0) {
        
            // Retrieve payment record
            $row = $foundPayment->fetch(PDO::FETCH_ASSOC);
                
            extract($row);

            // "Description for data" => payment property (fields from db)
            $paymnetArray=array(
                "payment Number" => $p_num,
                "Payment Contract Number" => $p_contract_num,
                "Date" => $p_date,
                "Price" => $p_price,
                "Card Number" => $p_card_num
            );
        
            // Set response code - 200 OK
            http_response_code(200);
        
            // Show payments data in json format
            echo json_encode($paymnetArray);
        }
        else {
        
            // Set response code - 404 Not Found
            http_response_code(404);
        
            // Tell the user no payments found
            echo json_encode(
                array("Message" => "No payment found.")
            );
        }
    }
    // Missing payment Number
    else {

        // HTTP status code - 400 Bad Request
        http_response_code(400);

        echo json_encode(array("Message" => "Bad Request. Incomplete Data"));
    }
?>