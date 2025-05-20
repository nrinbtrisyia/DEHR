<?php
// Import database
session_start();
include("../connection.php");

if (isset($_SESSION["user"])) {
    if ($_SESSION["user"] == "" or $_SESSION['usertype'] != 's') {
        header("location: ../login.php");
    } else {
        $useremail = $_SESSION["user"];
    }
} else {
    header("location: ../login.php");
}


if ($_POST) {
    
    
    // Retrieve form data
    $patientID = $_POST["patientID"];
    $apponum = $_POST["apponum"];
    $scheduleid = $_POST["scheduleid"];
   // $dateTime = $_POST["dateTime"];
    // $doctorID = $_POST["doctorID"];
    // $description = $_POST["description"];
	
	// Get schedule with ID 1 (replace 1 with the desired ID)
	$sql = "SELECT * FROM schedule WHERE scheduleid = '$scheduleid'";

	// Execute query
	$result = $database->query($sql);
	$dateTime = null;
	// Check if a row was returned
	if ($result->num_rows > 0) {
		// Fetch the single row
		$row = $result->fetch_assoc();
		$dateTime = $row['scheduledate'];
	}
	
    // Insert appointment into the database
    $sql = "INSERT INTO appointment (patientID, apponum, scheduleid, dateTime) VALUES ($patientID, $apponum, $scheduleid, '$dateTime')";

    $result = $database->query($sql);
	
    // Redirect to schedule page with a success message
    header("location: appointment.php");
}

//get patients
$sql = "SELECT * FROM patient";

// Execute query
$result = $database->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Initialize an array to store the results
    $rows = array();
    // Loop through the result set
    while ($row = $result->fetch_assoc()) {
        // Add each row to the array
        $patient[] = $row;
    }
    // Output the data
    // print_r($rows);
    echo json_encode($rows);
} else {
    echo json_encode(array('message' => 'No results'));
}

//get schedule
$sql = "SELECT * FROM schedule";

// Execute query
$result = $database->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Initialize an array to store the results
    $rows = array();
    // Loop through the result set
    while ($row = $result->fetch_assoc()) {
        // Add each row to the array
        $schedule[] = $row;
    }
    // Output the data
    // print_r($rows);
    echo json_encode($rows);
} else {
    echo json_encode(array('message' => 'No results'));
}


//get doctor
$sql = "SELECT * FROM doctor";

// Execute query
$result = $database->query($sql);

// Check if any rows were returned
if ($result->num_rows > 0) {
    // Initialize an array to store the results
    $rows = array();
    // Loop through the result set
    while ($row = $result->fetch_assoc()) {
        // Add each row to the array
        $doctor[] = $row;
    }
    // Output the data
    // print_r($rows);
    echo json_encode($rows);
} else {
    echo json_encode(array('message' => 'No results'));
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Add Appointment</title>
    <style>
        .popup{
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
</head>
<body>

<div id="popup1" class="overlay">
    <div class="popup">
        <center>
            <a class="close" href="appointment.php">&times;</a> 
            <div style="display: flex;justify-content: center;">
                <div class="abc">
				<form method="post" action="">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr>
                            <td>
                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add New Appointment</p><br>
                            </td>
                        </tr>
							<tr>
								<td class="label-td" colspan="2">
								<label for="patientID" class="form-label">Patient:</label>
										<select name="patientID" class="input-text" required>
											<?php foreach ($patient as $key => $row) : ?>
												<option value="<?php echo $row['patientID']; ?>"><?php echo $row['patientID']; ?> <?php echo $row['fullname']; ?></option>
											<?php endforeach; ?>
										</select>
								</td>
							</tr>

                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="apponum" class="form-label">Appointment Number:</label>
                                    <input type="number" name="apponum" class="input-text" required><br>
                                </td>
                            </tr>
                            
							
							<tr>
								<td class="label-td" colspan="2">
								<label for="patientID" class="form-label">Schedule ID:</label>
										<select name="scheduleid" class="input-text" required>
											<?php foreach ($schedule as $key => $row) : ?>
												<option value="<?php echo $row['scheduleid']; ?>"><?php echo $row['scheduleid']; ?> <?php echo $row['title']; ?> <?php echo $row['scheduledate']; ?> <?php echo $row['scheduletime']; ?></option>
											<?php endforeach; ?>
										</select>
								</td>
							</tr>
							
                           <!-- <tr>
                                <td class="label-td" colspan="2">
                                    <label for="dateTime" class="form-label">Date and Time:</label>
                                    <input type="datetime-local" name="dateTime" class="input-text" required><br>
                                </td>
                            </tr> -->
                           
							</tr>
                            <!-- <tr>
                                <td class="label-td" colspan="2">
                                    <label for="description" class="form-label">Description:</label>
                                   <!-- <input type="text" name="description" class="input-text" required> -->
									<!-- <textarea name="description" class="input-text" ></textarea>
                                </td> -->
                            <!-- </tr> --> 
                            <tr>
                                <td colspan="2">
                                    <input type="submit" value="Add Appointment" class="login-btn btn-primary btn" name="appointmentsubmit">
                                </td>
                            </tr>
                    </tr>
                </table>
			</form>
            </div>
        </div>
    </center>
    <br><br>
</div>
</div>

</body>
</html>

