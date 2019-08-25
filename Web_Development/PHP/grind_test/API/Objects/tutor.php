<?php
/*
    Tutor class. Includes properties and CRUD methods.
    Actual CRUD operations are made in separate scripts
    which initialize an object from this class.
*/
    // Script for validating any user input
    include_once "../Shared/testInput.php";
    
    class Tutor {
    
        // Database connection and table name
        private $conn;
        private $tableName = "Tutor_table";
        private $subjectTable='Subject_table';
        // Tutor properties
        public $t_num;
        public $t_fname;
        public $t_lname;
        public $t_bdate;
        public $t_sex;
        public $t_email;
        public $t_password;     // TODO: Remove. Only for developing purposes
        public $t_address;
        public $t_fee;          // How much tutor wants for an hour
        public $t_subject_num;  // Subject tutor teaches
        public $t_location;
       
        //Subject_table items
        public $subject_name;
        public $subject_level;
    
        // Constructor with $db as database connection
        public function __construct($db) {
            $this->conn = $db;
        }

        // Fetch all tutors
        function fetchAll() {
        
            // Select all 
            $query = "SELECT * FROM ".$this->tableName;
        
            // Prepare query statement
            $tutors = $this->conn->prepare($query);
        
            // Execute query
            $tutors->execute();
        
            return $tutors;
        }
        
        //Select tutors with fee
        function fetchTutorFee(){
        
            // Select all 
            $query = "SELECT * FROM $this->tableName WHERE t_fee <= $this->t_fee";
            
            // Prepare query statement
            $tutors = $this->conn->prepare($query);
        
            // Execute query
            $tutors->execute();
            
            return $tutors;
        }
        
        function fetchTutorThree(){
            
            //Select the info we need
            $query = "SELECT * FROM Tutor_table
            INNER JOIN Subject_table
            ON (t_subject_num = subject_num)
            where t_location = :bindLocation and subject_name = :bindSubject and subject_level = :subjectLevel";
            //Prepare query statement
            //Done this way to prevent SQL Injections
            $tutors = $this->conn->prepare($query);
            
            $tutors->bindParam(":bindLocation",$this->t_location);
            $tutors->bindParam(":bindSubject",$this->subject_name);
            $tutors->bindParam(":subjectLevel",$this->subject_level);

            
            // Execute query
            $tutors->execute();
            return $tutors;
        }

        // Register
        function register() {

            // Validate user input
            $this->t_fname       = testInput($this->t_fname);
            $this->t_lname       = testInput($this->t_lname);
            $this->t_bdate       = testInput($this->t_bdate);
            $this->t_sex         = testInput($this->t_sex);
            $this->t_email       = testInput($this->t_email);
            $this->t_password    = testInput($this->t_password);
            $this->t_address     = testInput($this->t_address);
            $this->t_fee         = testInput($this->t_fee);   
            $this->t_subject_num = testInput($this->t_subject_num);

            // Check that tutor is not registered already
            $result = $this->conn->query("SELECT * FROM $this->tableName WHERE t_email LIKE '$this->t_email'");

            if ($result->rowCount() === 0) {

                // Insert query
                $query = "INSERT INTO $this->tableName 
                          (t_fname, t_lname, t_bdate, t_sex, t_email, t_password, t_address, t_fee, t_subject_num)
                          VALUES
                          (:firstName, :lastName, :birthday, :sex, :email, :hashedPassword, :street, :fee, :subjectNum)";

                // Prepare insert statement
                $insert = $this->conn->prepare($query);

                $insert->bindParam(":firstName", $this->t_fname);
                $insert->bindParam(":lastName", $this->t_lname);
                $insert->bindParam(":birthday", $this->t_bdate);
                $insert->bindParam(":sex", $this->t_sex);
                $insert->bindParam(":email", $this->t_email);
                $insert->bindParam(":street", $this->t_address);
                $insert->bindParam(":fee", $this->t_fee);
                $insert->bindParam(":subjectNum", $this->t_subject_num);
                // Hash password before storing it
                $this->t_password = password_hash($this->t_password, PASSWORD_DEFAULT);
                $insert->bindParam(":hashedPassword", $this->t_password);

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
            $this->t_email      = testInput($this->t_email);
            $this->t_password   = testInput($this->t_password);

            // Fetch data from db with given email
            $result = $this->conn->query("SELECT * FROM $this->tableName WHERE t_email LIKE '$this->t_email'");

            // Check that tutor exists in database
            if ($result->rowCount() === 1) {

                // Fetch user record from result
                $user = $result->fetch();

                // Check password match
                if (password_verify($this->t_password, $user["t_password"])) {
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

            // FIXME For some reason t_email = $this->t_email results in SQL error
            // Using conn->query also makes this vulnerable to SQL injection
            // But prepare and execute refused to work for me
            $query = "SELECT t_num FROM $this->tableName WHERE t_email LIKE '$this->t_email'";

            try {
                $result = $this->conn->query($query);
            }
            catch (PDOException $e) {
                echo $e;
            }

            // Fetch tutor ID as integer
            $tutorID = (int)$result->fetchColumn();

            return $tutorID;
        }

         // Update tutor record
         function update() {

            // Validate user input
            $this->t_fname       = testInput($this->t_fname);
            $this->t_lname       = testInput($this->t_lname);
            $this->t_bdate       = testInput($this->t_bdate);
            $this->t_sex         = testInput($this->t_sex);
            $this->t_email       = testInput($this->t_email);
            $this->t_password    = testInput($this->t_password);
            $this->t_address     = testInput($this->t_address);
            $this->t_fee         = testInput($this->t_fee);   
            $this->t_subject_num = testInput($this->t_subject_num);

            // Fetch data from db with given tutor ID
            $result = $this->conn->query("SELECT * FROM $this->tableName WHERE t_num = $this->t_num");
            // Check that tutor exists in database
            if ($result->rowCount() === 1) {
                
                // Update query 
                $query = "UPDATE $this->tableName 
                          SET   t_fname = :firstName, t_lname = :lastName, t_bdate = :birthday, 
                                t_sex = :sex, t_email = :email, t_password = :hashedPassword,
                                t_address = :_address, t_fee = :fee, t_subject_num =:subNumber
                          WHERE t_num = :tutorID;";

                // Prepare update statement
                $update = $this->conn->prepare($query);

                $update->bindParam(":firstName", $this->t_fname);
                $update->bindParam(":lastName",  $this->t_lname);
                $update->bindParam(":birthday",  $this->t_bdate);
                $update->bindParam(":sex",       $this->t_sex);
                $update->bindParam(":email",     $this->t_email);
                $update->bindParam(":_address",  $this->t_address);
                $update->bindParam(":fee",       $this->t_fee);
                $update->bindParam(":subNumber", $this->t_subject_num);
                $update->bindParam(":tutorID",   $this->t_num);

                // Hash password before storing it
                $this->t_password = password_hash($this->t_password, PASSWORD_DEFAULT);
                $update->bindParam(":hashedPassword", $this->t_password);

                // Update tutor
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

        // Delete tutor record
        function delete() {

            // Fetch data from db with given tutor ID
            $result = $this->conn->query("SELECT * FROM $this->tableName WHERE t_num = $this->t_num");
            
            // Check that tutor exists in database
            if ($result->rowCount() === 1) {

                // Delete query 
                $query = "DELETE FROM $this->tableName WHERE t_num = :tutorID;";

                // Prepare delete statement
                $delete = $this->conn->prepare($query);

                $delete->bindParam(":tutorID", $this->t_num);

                // Delete tutor
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