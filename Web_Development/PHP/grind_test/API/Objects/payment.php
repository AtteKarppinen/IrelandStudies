<?php
/*
    Payment class. Includes properties and CRD methods.
    Actual CRD operations are made in separate scripts
    which initialize an object from this class.
*/

    // Script for validating any user input
    include_once "../Shared/testInput.php";


    class Payment {

        // Database connection and table name
        private $conn;
        private $tableName = "Payment_table";
    
        // Payment properties
        public $p_num;
        public $p_contract_num;
        public $p_date;
        public $p_price;
        public $p_card_num;
        
    
        // Constructor with $db as database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // Fetch all payment
        function fetchAll() {
        
            // Select all 
            $query = "SELECT * FROM ".$this->tableName;
        
            // Prepare query statement
            $payment = $this->conn->prepare($query);
        
            // Execute query
            $payment->execute();
        
            return $payment;
        }

        // Fetch payment with Number

        function fetchWithNumber() {

            // Select all 

            $query = "SELECT * FROM $this->tableName WHERE p_num = $this->p_num";
        
            // Prepare query statement
            $payment = $this->conn->prepare($query);
        
            // Execute query
            $payment->execute();
        
            return $payment;
        }


        // All data is sent in request's body, no need for parameters
        function writePayLog() {
          
            // Validate user input
            $this->p_contract_num  = testInput($this->p_contract_num);
            $this->p_date          = testInput($this->p_date);
            $this->p_price         = testInput($this->p_price);
            $this->p_card_num      = testInput($this->p_card_num);


            // Insert query 
            $query = "INSERT INTO $this->tableName (p_contract_num, p_date, p_price, p_card_num)
                        VALUES(:contractNumber, :date, :price, :cardNumber)";

            // Prepare insert statement
            $insert = $this->conn->prepare($query);

            $insert->bindParam(":contractNumber", $this->p_contract_num);
            $insert->bindParam(":date", $this->p_date);
            $insert->bindParam(":price", $this->p_price);
            $insert->bindParam(":cardNumber", $this->p_card_num);

            // Send new user to DB
            try {
                $insert->execute();
                return true;
            }
            catch(PDOException $e) {
                echo $e;
                return false;
            }
        }

    
        // Delete payment record
        function delete() {

            // Fetch data from db with given payment Number
            $result = $this->conn->query("SELECT * FROM $this->tableName WHERE p_num = $this->p_num");
            
            // Check that payment exists in database
            if ($result->rowCount() === 1) {

                // Delete query 
                $query = "DELETE FROM $this->tableName WHERE p_num = :payNumber;";

                // Prepare delete statement
                $delete = $this->conn->prepare($query);

                $delete->bindParam(":payNumber", $this->p_num);

                // Delete contract
                try {
                    $delete->execute();
                    return true;
                }
                catch(PDOException $e) {
                    return false;
                }
            }
            else {
                return false;
            }
        }
    }
?>