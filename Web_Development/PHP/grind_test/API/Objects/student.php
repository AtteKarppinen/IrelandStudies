<?php
/*
    Student class. Includes properties and CRUD methods.
    Actual CRUD operations are made in separate scripts
    which initialize an object from this class.
*/

    // Script for validating any user input
    include_once "../Shared/testInput.php";

    class Student {

        // Database connection and table name
        private $conn;
        private $tableName = "Student_table";
    
        // Student properties
        public $s_num;
        public $s_fname;
        public $s_lname;
        public $s_bdate;
        public $s_sex;
        public $s_email;
        public $s_password;     
        //public $s_address;    // Probably not necessary
        // public $Location;    // Probably not necessary
    
        // Constructor with $db as database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // Fetch all students
        function fetchAll() {
        
            // Select all 
            $query = "SELECT * FROM ".$this->tableName;
        
            // Prepare query statement
            $students = $this->conn->prepare($query);
        
            // Execute query
            $students->execute();
        
            return $students;
        }

        // Fetch student with ID
        function fetchWithID() {

            // Select all 
            $query = "SELECT * FROM $this->tableName WHERE s_num = $this->s_num";
        
            // Prepare query statement
            $student = $this->conn->prepare($query);
        
            // Execute query
            $student->execute();
        
            return $student;
        }

        // All data is sent in request's body, no need for parameters
        function register() {

            // Validate user input
            $this->s_fname      = testInput($this->s_fname);
            $this->s_lname      = testInput($this->s_lname);
            $this->s_bdate      = testInput($this->s_bdate);
            $this->s_sex        = testInput($this->s_sex);
            $this->s_email      = testInput($this->s_email);
            $this->s_password   = testInput($this->s_password);

            // Check that student is not registered already
            $result = $this->conn->query("SELECT * FROM $this->tableName WHERE s_email LIKE '$this->s_email'");
            
            if ($result->rowCount() === 0) {

                // Insert query 
                $query = "INSERT INTO $this->tableName (s_fname, s_lname, s_bdate, s_sex, s_email, s_password)
                          VALUES(:firstName, :lastName, :birthday, :sex, :email, :hashedPassword)";

                // Prepare insert statement
                $insert = $this->conn->prepare($query);

                $insert->bindParam(":firstName", $this->s_fname);
                $insert->bindParam(":lastName", $this->s_lname);
                $insert->bindParam(":birthday", $this->s_bdate);
                $insert->bindParam(":sex", $this->s_sex);
                $insert->bindParam(":email", $this->s_email);
                // Hash password before storing it
                $this->s_password = password_hash($this->s_password, PASSWORD_DEFAULT);
                $insert->bindParam(":hashedPassword", $this->s_password);

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
            else {
                return false;
            }
        }

        // Same like in registration, expect data in body
        function login() {

            // Validate user input
            $this->s_email      = testInput($this->s_email);
            $this->s_password   = testInput($this->s_password);

            // Fetch data from db with given email
            $result = $this->conn->query("SELECT * FROM $this->tableName WHERE s_email LIKE '$this->s_email'");

            // Check that student exists in database
            if ($result->rowCount() === 1) {

                // Fetch user record from result
                $user = $result->fetch();

                // Check password match
                if (password_verify($this->s_password, $user["s_password"])) {
                    return true;
                }
                // Passwords do not match
                else {
                    return false;
                }
            }
            // User with given email not in database
            else {
                return false;
            }
        }

        // Fetch user ID
        function fetchID() {

            // FIXME For some reason s_email = $this->s_email results in SQL error
            // Using conn->query also makes this vulnerable to SQL injection
            // But prepare and execute refused to work for me
            $query = "SELECT s_num FROM $this->tableName WHERE s_email LIKE '$this->s_email'";

            try {
                $result = $this->conn->query($query);
            }
            catch (PDOException $e) {
                echo $e;
            }

            // Fetch student ID as integer
            $studentID = (int)$result->fetchColumn();

            return $studentID;
        }

        // Update student record
        function update() {

            // Validate user input
            $this->s_fname      = testInput($this->s_fname);
            $this->s_lname      = testInput($this->s_lname);
            $this->s_bdate      = testInput($this->s_bdate);
            $this->s_sex        = testInput($this->s_sex);
            $this->s_email      = testInput($this->s_email);
            $this->s_password   = testInput($this->s_password);

            // Fetch data from db with given student ID
            $result = $this->conn->query("SELECT * FROM $this->tableName WHERE s_num = $this->s_num");
            
            // Check that student exists in database
            if ($result->rowCount() === 1) {

                // Update query 
                $query = "UPDATE $this->tableName 
                          SET   s_fname = :firstName, s_lname = :lastName, s_bdate = :birthday, 
                                s_sex = :sex, s_email = :email, s_password = :hashedPassword
                          WHERE s_num = :studentID;";

                // Prepare update statement
                $update = $this->conn->prepare($query);

                $update->bindParam(":firstName", $this->s_fname);
                $update->bindParam(":lastName", $this->s_lname);
                $update->bindParam(":birthday", $this->s_bdate);
                $update->bindParam(":sex", $this->s_sex);
                $update->bindParam(":email", $this->s_email);
                $update->bindParam(":studentID", $this->s_num);
                // Hash password before storing it
                $this->s_password = password_hash($this->s_password, PASSWORD_DEFAULT);
                $update->bindParam(":hashedPassword", $this->s_password);

                // Update student
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

        // Delete student record
        function delete() {

            // Fetch data from db with given student ID
            $result = $this->conn->query("SELECT * FROM $this->tableName WHERE s_num = $this->s_num");
            
            // Check that student exists in database
            if ($result->rowCount() === 1) {

                // Delete query 
                $query = "DELETE FROM $this->tableName WHERE s_num = :studentID;";

                // Prepare delete statement
                $delete = $this->conn->prepare($query);

                $delete->bindParam(":studentID", $this->s_num);

                // Delete student
                try {
                    $delete->execute();
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
    }
?>