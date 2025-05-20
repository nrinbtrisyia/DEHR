<?php
// Import database
include("../connection.php");
session_start();

if (isset($_SESSION["user"])) {
    if ($_SESSION["user"] == "" or $_SESSION['usertype'] != 'd') {
        header("location: ../login.php");
    } else {
        $useremail = $_SESSION["user"];
    }
} else {
    header("location: ../login.php");
}

$conn = $database;

if ($_POST) {
    // Import database
	
	print_r($_POST);
	if(isset($_POST['fetchid'])){
		$fetchid = $_POST['fetchid'];
	}else{
		echo 'NO ID';
		exit;
	}
	
	
	
	// SQL query to select data for a specific email
	$sql = "SELECT * FROM appointment WHERE appID = '$fetchid' LIMIT 1";

	// Execute query
	$result = $conn->query($sql);
	$doctorID = NULL;

	// Check if a row was returned
	if ($result->num_rows == 1) {
		// Fetch the row
		$row = $result->fetch_assoc();
		
	} else {
		echo json_encode(array('message' => 'No results or multiple results'));
	}

    
    // Retrieve form data
    $patientID = $row["patientID"];
    $apponum = $row["apponum"];
    $scheduleid = $row["scheduleid"];
    $dateTime = $row["dateTime"];
    $doctorID = $row["doctorID"];
    $description = $row["description"];
    
    // Insert appointment into the database
    $sql = "INSERT INTO appointment (patientID, apponum, scheduleid, dateTime, doctorID, description) VALUES ($patientID, $apponum, $scheduleid, '$dateTime', $doctorID, '$description')";
    $result = $database->query($sql);
	// Get the ID of the last inserted record
	$newid = $database->insert_id;
	
	if(isset($newid)){
	}else{
		echo 'NO REDIRECT ID';
		exit;
	}
    // Redirect to schedule page with a success message
    header("location: edit-appointment.php?action=featch&id=".$newid);
}

?>
