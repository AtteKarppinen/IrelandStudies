<?php
/*
    Script for token settings
*/

    include_once "../Objects/token.php";

    // Show error reporting
    error_reporting(E_ALL);
    
    // Default time-zone
    date_default_timezone_set("Europe/Dublin");

    // Token object
    // $tokenObject = new Token();

    // Set expiration to one day when issued
    // 60min * 60s = 1h
    $expiration = (time() + 24 * 60 * 60);
    
    // Variables used for jwt
    // $key = "super_secret_key";
    // $exp = $expiration;
    // $tokenObject->key = "super_secret_key";
    // $tokenObject->exp = $expiration;
?>