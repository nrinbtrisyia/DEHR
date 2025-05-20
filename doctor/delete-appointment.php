<?php
session_start();
include("../connection.php"); // Adjust the path as necessary

// Get appointment ID from request
$id = $_GET["id"];

// Delete appointment
$sql = "DELETE FROM appointment WHERE appID ='$id'";
if ($database->query($sql) === TRUE) {
    // Return success response
    http_response_code(200); // Set success status code
    echo json_encode(array("message" => "Record deleted successfully"));

    // Redirect to appointment.php after a delay
    echo "<script>
            setTimeout(function() {
                window.location.href = 'appointment.php';
            }, 2000); // 2000 milliseconds delay
          </script>";
    exit();
} else {
    // Return error response
    http_response_code(500); // Set internal server error status code
    echo json_encode(array("message" => "Error deleting record: " . $database->error));
    exit();
}
?>
