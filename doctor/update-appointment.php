<?php
session_start();
include("../connection.php"); // Adjust the path as necessary
$conn = $database;
//print_r($_GET);


// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // Get form data
    $appId = $_POST['appointmentId'];
    $patientId = $_POST['patientId'];
    $patientName = $_POST['patientName'];
    $doctorId = $_POST['doctorName'];
    $medicalPlan = $_POST['medicalPlan'];
    $treatment = $_POST['treatment'];
    $description = $_POST['description'];
    $session = $_POST['session'];

    // Construct update query
    $sql = "UPDATE appointment SET 
	medicalPlan = '$medicalPlan', 
	treatment = '$treatment', 
	description = '$description' 
	WHERE appID = '$appId'";

   // Execute update query
    if ($conn->query($sql) === TRUE) {
        echo '<div id="countdown" style="background-color: #dff0d8; color: #3c763d; padding: 10px; border: 1px solid #d6e9c6; margin-bottom: 10px;">Record updated successfully. Redirecting in <span id="count">5</span> seconds...</div>';
        echo "<script>
                var count = 5;
                var countdown = setInterval(function() {
                    count--;
                    document.getElementById('count').innerText = count;
                    if (count === 0) {
                        clearInterval(countdown);                                               
                        window.location.href = 'add-appointment2.php?action=add-record&id=none&error=" . $appId . "&patientId=" . $patientId . "&session=" . $session . "&patientName=". $patientName . "';
                    }
                }, 1000);
              </script>";
        exit();
    } else {
        echo '<div style="background-color: #f2dede; color: #a94442; padding: 10px; border: 1px solid #ebccd1; margin-bottom: 10px;">Error updating record: ' . $conn->error . '</div>';
    }

    // Close database connection  //error
    $conn->close();
}

?>