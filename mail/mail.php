<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $subject = $_POST["subject"];
    $yourmessage = $_POST["yourmessage"];

    // Database connection
    $host = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbname = "DEHR";

    // Create connection
    $conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: ". $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO contact (name, email, phone, subject, yourmessage) VALUES (?,?,?,?,?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $subject, $yourmessage);

    // Set parameters and execute
    if ($stmt->execute()) {
        echo "<script>
                alert('New records created successfully');
                window.location.href='index.html';
              </script>";
    } else {
        echo "<script>
                alert('Error: " . $stmt->error . "');
                window.location.href='index.html'; // Redirect to index.html even if there is an error
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?>
