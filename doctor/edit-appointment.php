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

$schedule_sql = "SELECT * FROM schedule";
$schedule_result = $conn->query($schedule_sql);

$schedules = [];
if ($schedule_result->num_rows > 0) {
    while($schedule_row = $schedule_result->fetch_assoc()) {
        $schedules[] = $schedule_row;
    }
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
            <label for="appointmentId">Appointment Number:</label>
            <input type="text" id="appointmentId" name="appointmentId" value="<?php echo $row['appID']; ?>" readonly>

            <label for="patientName">Patient Name:</label>
            <input type="hidden" id="patientId" name="patientId" value="<?php echo $row['patientID']; ?>" readonly>
            <input type="text" id="patientName" name="patientName" value="<?php echo $row['fullname']; ?>" readonly>

            <label for="doctorName">Doctor Name:</label>
            <input type="text" id="doctorName" name="doctorName" value="<?php echo $row['fname']; ?>" readonly>
            
            <label for="medicalPlan">Medical Plan:</label>
            <input type="text" id="medicalPlan" name="medicalPlan" value="<?php echo $row['medicalPlan']; ?>">

            <label for="treatment">Treatment:</label>
            <input type="text" id="treatment" name="treatment" value="<?php echo $row['treatment']; ?>">

            <label for="description">Description:</label>
            <textarea id="description" name="description"><?php echo $row['description']; ?></textarea>

            <label>Session</label>
            <select style="margin-bottom: 20px;" id="session" name="session">
                <?php foreach ($schedules as $schedule): ?>
                    <option value="<?php echo $schedule['scheduleid']; ?>" <?php echo $row['scheduleid'] == $schedule['scheduleid'] ? 'selected' : ''; ?>>
                        <?php echo $schedule['title'] . ' - ' . $schedule['scheduledate'] . ' ' . $schedule['scheduletime']; ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Submit</button>
        </form>
        <div style="margin-top: 20px;">
            <a href="record.php?action=add-record&id=none&error=0">Back</a>
        </div>
    </div>
</body>
</html>

