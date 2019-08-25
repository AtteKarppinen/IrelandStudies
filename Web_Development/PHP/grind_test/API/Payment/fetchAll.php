<?php

/*
    This script is resbonsible for fetching payments from 
    database and returning them in json-format.

    Now $paymnet->read() call returns every payment
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
    include_once "../Objects/payment.php";
    
    
    // Instantiate database
    $database = new Database();
    $db = $database->getConnection();
    
    // Initialize payment object
    $payment = new payment($db);

    // Query payments
    $payments = $payment->fetchAll();
    $num = $payments->rowCount();
    
    // Check if more than 0 record found
    if ($num > 0) {
    
        // payments array
        $paymentsArray["Payments"] = array();
    
        // Retrieve our table contents
        while ($row = $payments->fetch(PDO::FETCH_ASSOC)) {
            
            extract($row);
    
            // "Description for data" => Payment property (fields from db)
            $paymentItem=array(
                "Payment number" => $p_num,
                "Payment contract number" => $p_contract_num,
                "Payment date" => $p_date,
                "Payment price" => $p_price,
                "Payment card number" => $p_card_num
            );
            array_push($paymentsArray["Payments"], $paymentItem);
        }
    
        // Set response code - 200 OK
        http_response_code(200);
    
        // Show payments data in json format
        echo json_encode($paymentsArray);
    }
    else {
    
        // Set response code - 404 Not Found
        http_response_code(404);
    
        // Tell the user no paymnets found
        echo json_encode(
            array("Message" => "No payments found.")
        );
    }
?>