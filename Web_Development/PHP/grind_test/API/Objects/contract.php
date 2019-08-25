<?php
/*
    Contract class. Includes properties and CRUD methods.
    Actual CRUD operations are made in separate scripts
    which initialize an object from this class.
*/

    // Script for validating any user input
    include_once "../Shared/testInput.php";


    class Contract {

        // Database connection and table name
        private $conn;
        private $tableName = "Contract_table";
    
        // Contract properties
        public $contract_num;
        public $contract_student_num;
        public $contract_tutor_num;
        public $contract_subject_num;
        
    
        // Constructor with $db as database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // Fetch all contracts
        function fetchAll() {
        
            // Select all 
            $query = "SELECT * FROM ".$this->tableName;
        
            // Prepare query statement
            $contract = $this->conn->prepare($query);
        
            // Execute query
            $contract->execute();
        
            return $contract;
        }

        // Fetch contract detail 

        function fetchDetail(){
            $query = 
            "SELECT contract_num, t_fname, t_lname , s_fname, s_lname , contract_subject_num 
            FROM 
            (SELECT contract_num, t_fname, t_lname , contract_student_num, contract_subject_num
            FROM Tutor_table
            JOIN $this->tableName
            ON Tutor_table.t_num = $this->tableName.contract_num) as col
            JOIN Student_table
            ON col.contract_student_num = Student_table.s_num";

            //Prepare query statement
            $contract = $this->conn->prepare($query);

            // Execute query
            $contract->execute();

            return $contract;
        }

        // Fetch contract with Number
        function fetchWithNumber() {

            // Select all 
            $query = "SELECT * FROM $this->tableName WHERE contract_num = $this->contract_num";
        
            // Prepare query statement
            $contract = $this->conn->prepare($query);
        
            // Execute query
            $contract->execute();
        
            return $contract;
        }


        // All data is sent in request's body, no need for parameters
        function makecontract() {
            
            // Validate user input
            $this->contract_student_num  = testInput($this->contract_student_num);
            $this->contract_tutor_num    = testInput($this->contract_tutor_num);
            $this->contract_subject_num  = testInput($this->contract_subject_num);
            // Insert query 
            $query = "INSERT INTO $this->tableName (contract_student_num, contract_tutor_num, contract_subject_num)
                        VALUES(:studentnumber, :tutornumber, :subjectnumber)";

            // Prepare insert statement
            $insert = $this->conn->prepare($query);

            $insert->bindParam(":studentnumber", $this->contract_student_num);
            $insert->bindParam(":tutornumber", $this->contract_tutor_num);
            $insert->bindParam(":subjectnumber", $this->contract_subject_num);

            // Send new user to DB
            try {
                $insert->execute();
                return true;
            }
            catch(PDOException $e) {
                return false;
            }
        }

        
        // Update contract record
        function update() {
            // Validate user input
            $this->contract_num            = testInput($this->contract_num);
            $this->contract_student_num    = testInput($this->contract_student_num);
            $this->contract_tutor_num      = testInput($this->contract_tutor_num);
            $this->contract_subject_num    = testInput($this->contract_subject_num);
            // Fetch data from db with given contract number
            $result = $this->conn->query("SELECT * FROM $this->tableName WHERE contract_num = $this->contract_num");
            
            // Check that contract exists in database
            if ($result->rowCount() === 1) {
                echo $this->contract_num;
                echo $this->contract_student_num;
                echo $this->contract_subject_num;
                echo $this->contract_tutor_num;
                
                // Update query 
                $query = "UPDATE $this->tableName 
                          SET   contract_student_num = :studentnumber, 
                                contract_tutor_num = :tutornumber, 
                                contract_subject_num = :subjectnumber
                          WHERE contract_num = :contractnumber;";

                // Prepare update statement
                $update = $this->conn->prepare($query);

                $update->bindParam(":studentnumber", $this->contract_student_num);
                $update->bindParam(":tutornumber", $this->contract_tutor_num);
                $update->bindParam(":subjectnumber", $this->contract_subject_num);
                $update->bindParam(":contractnumber", $this->contract_num);

                // Update contract
                try {
                    $update->execute();
                    return true;
                }
                catch(PDOException $e) {
                    echo $e;
                    return false;
                }
            }
            else {
                return false;
            }
        }

        // Delete contract record
        function delete() {

            // Fetch data from db with given contract Number
            $result = $this->conn->query("SELECT * FROM $this->tableName WHERE contract_num = $this->contract_num");
            
            // Check that contract exists in database
            if ($result->rowCount() === 1) {

                // Delete query 
                $query = "DELETE FROM $this->tableName WHERE contract_num = :contractnumber;";

                // Prepare delete statement
                $delete = $this->conn->prepare($query);

                $delete->bindParam(":contractnumber", $this->contract_num);

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