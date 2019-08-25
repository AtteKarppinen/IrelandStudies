<?php
    class Model {

        public $formError;      // Make it public and pass to controller
        public $name;
        public $email;
        public $dob;
        public $addr1;
        public $city;
        public $zip;

        public function insertUserInfo() {

            if (isset($_POST['action']) && $_POST['action'] === 'Submit') {
                // Submit was initiated from the view (index.php)
                $host = 'localhost'; 
                $user = 'root'; 
                $pwd = ''; 
                $db = 'CV';
                
                try {
                    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pwd);
                    
                    // PDO error to exception
                    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    // echo 'Successful connection made';
                } 
                catch (PDOException $error) {
                    echo 'Connection failed: '.$error->getMessage();
                }
                
                function TestInput($data) {
                    $data = trim($data);              // Trims whitespace around
                    $data = stripslashes($data);      // Removes / and \
                    $data = htmlspecialchars($data);  // Disables code injections
                    return $data;
                }

                $this->formError = [];
                $this->name = $this->email = $this->dob = $this->addr1 = $this->city = $this->zip = '';
                
                if ($_SERVER['REQUEST_METHOD'] == 'POST') { // On submission
                    // NAME
                    if (empty($_POST['name_text'])) {
                        $this->formError['name'] = 'Name is required';
                    }
                    else {
                        $this->name = TestInput($_POST['name_text']);
                        if (!preg_match("^[A-Za-zÀ-ÿ ,.'-]+$^", $this->name)) {
                            $this->formError['name'] = 'Check your spelling. Illegal characters found';
                        }
                    }
                    // EMAIL
                    if (empty($_POST['email_text'])) {
                        $this->formError['email'] = 'Email is required';
                    }
                    else {
                        $this->email = TestInput($_POST['email_text']);
                        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
                            $this->formError['email'] = 'Check your spelling. Illegal characters found';
                        }
                    }
                    // DOB
                    if (empty($_POST['date_picker'])) {
                        $this->formError['date'] = 'Date is required';
                    }
                    else {
                        $this->dob = $_POST['date_picker'];
                    }
                    // GENDER
                    if (empty($_POST['select_gender'])) {
                        $this->formError['gender'] = 'Gender is required';
                    }
                    // ADDR1
                    if (empty($_POST['addr1_text'])) {
                        $this->formError['addr1'] = 'Address is required';
                    }
                    else {
                        $this->addr1 = TestInput($_POST['addr1_text']);
                    }
                    // CITY
                    if (empty($_POST['city_text'])) {
                        $this->formError['city'] = 'City is required';
                    }
                    else {
                        $this->city = TestInput($_POST['city_text']);
                        if (!preg_match("^[A-Za-z]+$^", $this->city)) {
                            $this->formError['city'] = 'Only letter allowed';
                        }
                    }
                    // ZIP 
                    if (empty($_POST['zip_text'])) {
                        $this->formError['zip'] = 'Zip code is required';
                    }
                    else {
                        $this->zip = TestInput($_POST['zip_text']);
                        if (!preg_match("^\w+\s\d+^", $this->zip)) {
                            $this->formError['zip'] = 'Must have one word *space* and a number';
                        }
                    }
                    // Form is valid
                    if (empty($this->formError)) {
                        // Table example is just that. With one field that matters, user_info
                        $record_exists = $conn->query("SELECT * FROM example WHERE user_info LIKE '$this->name'");
                        if ($record_exists->rowCount() === 0) {
                            // Prepare insert statement
                            $insert = $conn->prepare('INSERT INTO example (user_info) VALUES (:user_name)');
                            $insert->bindParam(':user_name', $this->name);

                            // Send new user to DB
                            try {
                                $insert->execute();
                                // SUCCESSFUL INSERTION
                                return true;
                            }
                            catch(PDOException $e) {
                                // FAILURE
                                return false;
                            }
                        }
                        else {
                            echo "<script>alert('User with that name already exists');</script>";
                        }
                    }
                    return false;
                }
            }
        }
    }
?>