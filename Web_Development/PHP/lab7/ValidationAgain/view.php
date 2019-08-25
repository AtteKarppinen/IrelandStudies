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

    <h1>Personal Information</h1>
    <form name="personal_info" id="personal_info" method="POST" action="">
    <table align="center" border="0">
    <tbody><tr>
    <td class="name">
        Name:
    </td>
    <td class="data">
        <!-- Accept also most common symbols found in names -->
        <input type="text" name="name_text" id="name_text" width="20" maxlength="40" size="20" value="<?php if (isset($name)) echo $name?>">
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
        <input type="email" name="email_text" id="email_text" width="20" maxlength="40" size="20" value="<?php if (isset($email)) echo $email?>">
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
        <input type="text" name="date_picker" id="date_picker" size="20" autocomplete="off" value="<?php if (isset($dob)) echo $dob?>">
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
        <input type="text" name="addr1_text" id="addr1_text" width="6" size="6" maxlength="5" value="<?php if (isset($addr1)) echo $addr1?>">
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
        <input type="text" name="city_text" id="city_text" width="6" size="6" maxlength="5" value="<?php if (isset($city)) echo $city?>">
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
        <input type="text" name="zip_text" id="zip_text" width="6" size="6" maxlength="5" value="<?php if (isset($zip)) echo $zip?>">
        <?php if (isset($formError['zip'])) {
            echo '<span>*'.$formError['zip'].'</span><br>';
        }?>
    </td>
    </tr>
    <tr>
    <td class="name">
        <input type="submit" value="Submit" name="action">
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