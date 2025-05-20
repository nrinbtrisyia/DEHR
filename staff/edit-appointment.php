<?php
session_start();
include("../connection.php"); // Adjust the path as necessary
$conn = $database;
//print_r($_GET);

if(isset($_GET['id'])){
$id = $_GET['id'];
}else{
 echo 'NO ID';
 exit;
}

$sql = "SELECT * FROM appointment 
LEFT JOIN
patient ON patient.patientID = appointment.patientID
LEFT JOIN
doctor ON doctor.doctorID = appointment.doctorID
WHERE appID = '$id' LIMIT 1";

// Execute query
$result = $conn->query($sql);
$doctorID = NULL;

// Check if a row was returned
if ($result->num_rows == 1) {
    // Fetch the row
    $row = $result->fetch_assoc();
    // Output the data
   // print_r($row);
	
} else {
    echo json_encode(array('message' => 'No results or multiple results'));
}


?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Update Record</title>
<link rel="stylesheet" href="../css/form.css">  
<style>
  
</style>
</head>
<body>
    <div class="form-container">
        <h2>Update Record</h2>
        <form method="post" action="update-appointment.php">
            <label for="appointmentId">Appointment ID:</label>
            <input type="text" id="appointmentId" name="appointmentId" value="<?php echo $row['appID']; ?>" readonly>

            <label for="patientName">Patient Name:</label>
            <input type="text" id="patientName" name="patientName" value="<?php echo $row['fullname']; ?>" readonly>

            <label for="doctorName">Doctor Name:</label>
            <input type="text" id="doctorName" name="doctorName" value="<?php echo $row['fname']; ?>" readonly>
            
            <label for="medicalPlan">Medical Plan:</label>
            <input type="text" id="medicalPlan" name="medicalPlan" value="<?php echo $row['medicalPlan']; ?>">

            <label for="treatment">Treatment:</label>
            <input type="text" id="treatment" name="treatment" value="<?php echo $row['treatment']; ?>">

            <label for="description">Description:</label>
            <textarea id="description" name="description"><?php echo $row['description']; ?></textarea>

            <button type="submit">Submit</button>
            <button type="submit" name="generate-report" formaction="generate-report.php" formmethod="post">Generate Report</button>
            </form>
        </form>
        <div style="margin-top: 20px;">
            <a href="record.php?action=add-record&id=none&error=0">Back</a>
        </div>
    </div>
</body>
</html>

