<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PHP validation</title>

    <!-- Google JQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <!-- JQuery UI CSS-->
    <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" type="text/css">
    <!-- JQuery UI Js-->
    <script
        src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"
        integrity="sha256-DI6NdAhhFRnO2k51mumYeDShet3I8AKCQf/tf7ARNhI="
        crossorigin="anonymous">
    </script>
</head>
<body>
    <!-- Form validation -->    
    <!-- Validate using PHP -->
    <?php 
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

    $formError = [];
    $name = $email = $dob = $addr1 = $city = $zip = '';
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') { // On submission
        // NAME
        if (empty($_POST['name_text'])) {
            $formError['name'] = 'Name is required';
        }
        else {
            $name = TestInput($_POST['name_text']);
            if (!preg_match("^[A-Za-zÀ-ÿ ,.'-]+$^", $name)) {
                $formError['name'] = 'Check your spelling. Illegal characters found';
            }
        }
        // EMAIL
        if (empty($_POST['email_text'])) {
            $formError['email'] = 'Email is required';
        }
        else {
            $email = TestInput($_POST['email_text']);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $formError['email'] = 'Check your spelling. Illegal characters found';
            }
        }
        // DOB
        if (empty($_POST['date_picker'])) {
            $formError['date'] = 'Date is required';
        }
        else {
            $dob = $_POST['date_picker'];
        }
        // GENDER
        if (empty($_POST['select_gender'])) {
            $formError['gender'] = 'Gender is required';
        }
        // ADDR1
        if (empty($_POST['addr1_text'])) {
            $formError['addr1'] = 'Address is required';
        }
        else {
            $addr1 = TestInput($_POST['addr1_text']);
        }
        // CITY
        if (empty($_POST['city_text'])) {
            $formError['city'] = 'City is required';
        }
        else {
            $city = TestInput($_POST['city_text']);
            if (!preg_match("^[A-Za-z]+$^", $city)) {
                $formError['city'] = 'Only letter allowed';
            }
        }
        // ZIP 
        if (empty($_POST['zip_text'])) {
            $formError['zip'] = 'Zip code is required';
        }
        else {
            $zip = TestInput($_POST['zip_text']);
            if (!preg_match("^\w+\s\d+^", $zip)) {
                $formError['zip'] = 'Must have one word *space* and a number';
            }
        }
        // Form is valid
        if (empty($formError)) {
            // Table example is just that. With one field that matters, user_info
            $record_exists = $conn->query("SELECT * FROM example WHERE user_info LIKE '$name'");
            if ($record_exists->rowCount() === 0) {
                // Prepare insert statement
                $insert = $conn->prepare('INSERT INTO example (user_info) VALUES (:user_name)');
                $insert->bindParam(':user_name', $name);

                // Send new user to DB
                try {
                $insert->execute();
                echo "<script>alert('User successfully inserted');</script>";
                }
                catch(PDOException $e) {
                // Error
                }
                // Empty everything
                $name = $email = $dob = $addr1 = $city = $zip = '';
            }
            else {
                echo "<script>alert('User with that name already exists');</script>";
            }
        }
    }
    ?>

    <h1>Personal Information</h1>
    <form name="personal_info" id="personal_info" method="post" 
    action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>">
    <table align="center" border="0">
    <tbody><tr>
    <td class="name">
        Name:
    </td>
    <td class="data">
        <!-- Accept also most common symbols found in names -->
        <input type="text" name="name_text" id="name_text" width="20" maxlength="40" size="20" value="<?php echo $name?>">
        <?php if (isset($formError['name'])) {
            echo '<span>*'.$formError['name'].'</span><br>';
        }?>
    </td>
    </tr>
    <tr>
    <td class="name">
        E-mail address:
    </td>
    <td class="data">
        <input type="email" name="email_text" id="email_text" width="20" maxlength="40" size="20" value="<?php echo $email?>">
        <?php if (isset($formError['email'])) {
            echo '<span>*'.$formError['email'].'</span><br>';
        }?>
    </td>
    </tr>
    <tr>
    <td class="name">
        Date of Birth (DD/MM/YYYY):
    </td>
    <td class="data">
        <input type="text" name="date_picker" id="date_picker" size="20" autocomplete="off" value="<?php echo $dob?>">
        <?php if (isset($formError['dob'])) {
            echo '<span>*'.$formError['dob'].'</span><br>';
        }?>
    </td>
    </tr>
    <tr>
    <td class="name">
        Gender:
    </td>
    <td class="data">
        <select name="select_gender" id="select_gender">
            <option value="">Select gender</option> 
            <option value="F">Female</option>
            <option value="M">Male</option>
        </select>
        <?php if (isset($formError['gender'])) {
            echo '<span>*'.$formError['gender'].'</span><br>';
        }?>
    </td>
    </tr>
    <tr>
    <td class="name">
        Street address (line 1):
    </td>
    <td class="data">
        <input type="text" name="addr1_text" id="addr1_text" width="6" size="6" maxlength="5" value="<?php echo $addr1?>">
    <?php if (isset($formError['addr1'])) {
            echo '<span>*'.$formError['addr1'].'</span><br>';
    }?>
    </td>
    </tr>
    <tr>
    <td class="name">
        Street address (line 2):
    </td>
    <td class="data">
        <input type="text" name="addr2_text" id="addr2_text" width="6" size="6" maxlength="5">
    </td>
    </tr>
    <tr>
    <td class="name">
        City:
    </td>
    <td class="data">
        <input type="text" name="city_text" id="city_text" width="6" size="6" maxlength="5" value="<?php echo $city?>">
        <?php if (isset($formError['city'])) {
            echo '<span>*'.$formError['city'].'</span><br>';
        }?>
    </td>
    </tr>
    <tr>
    <td class="name">
        ZIP code:
    </td>
    <td class="data">
        <input type="text" name="zip_text" id="zip_text" width="6" size="6" maxlength="5" value="<?php echo $zip?>">
        <?php if (isset($formError['zip'])) {
            echo '<span>*'.$formError['zip'].'</span><br>';
        }?>
    </td>
    </tr>
    <tr>
    <td class="name">
        <input type="submit" value="Submit" id="submitBtn">
    </td>
    <td class="data">
        <input type="reset" value="Clear">
    </td>
    </tr>
    </tbody></table>
    </form>
    <script src="logic.js"></script>
</body>
</html>