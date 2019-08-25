<?php
    // Open and read file. Anything echoed will be returned
    $covertLetter = fopen("CovertLetter.txt", "r") or die("Unable to open file!");
    echo fread($covertLetter,filesize("CovertLetter.txt"));
    fclose($covertLetter);
?>