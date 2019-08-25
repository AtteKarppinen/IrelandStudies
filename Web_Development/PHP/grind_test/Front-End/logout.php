<?php
    // Destroy session and redirect to home page
    session_start();
    session_destroy();

    header("location: index.php");
?>