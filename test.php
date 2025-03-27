<?php
    // Database Connection setup
    $conn = new mysqli("localhost","root","","masks");
    if ($conn -> connect_errno) {
    echo "Failed to connect to MySQL: " . $conn -> connect_error;
    exit();
    }
    ?>