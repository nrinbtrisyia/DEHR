<?php
    // Create a new mysqli object with connection parameters
    $database = new mysqli("localhost", "root", "", "dehr");

    // Check if the connection was successful
    if ($database->connect_error) {
        // If connection failed, output an error message and terminate the script
        die("Connection failed: " . $database->connect_error);
    }

    include 'assets/phpqrcode/qrlib.php';
    include 'mail.php';

    // test sending mail
    sendmail('shahnazz.geo@gmail.com', 'Test', 'This is a test message');

    include 'settings.php';

?>
