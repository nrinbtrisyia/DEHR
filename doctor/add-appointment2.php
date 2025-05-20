<?php
// Import database
session_start();

include("../connection.php");

if (isset($_SESSION["user"])) {
    if ($_SESSION["user"] == "" or $_SESSION['usertype'] != 'd') {
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

    // generate QR code and email 
	
    $appointmentID = $database->insert_id;

    $link = "DEHR-" . sprintf("%06d", $appointmentID);
    QRcode::png($link, '../qrcodes/' . $appointmentID . '.png', QR_ECLEVEL_L, 4, 2);

    // get patient info (need to email)
    $sql = 'select * from patient where patientID = "' . $_POST['patientID'] . '" ';
    $qry = $database->query($sql);
    $patient = $qry->fetch_assoc();


    $message_content = '

        <h3>You Have An Appointment!</h3>
        <br>
        An appointment has been created for you. <br>
        Details of your appointment are as follows:<br>
        <br>
        Date: ' . date('d M Y', strtotime($dateTime)) . '<br>
        Time: ' . date('h:i a', strtotime($dateTime)) . '<br>
        <br>
        Please scan the QR coce below upon arriving at the clinic.<br>
        <br>
        <img alt="PHPMailer" src="cid:my-attach"><br>
        <br>
        We hope that you have a good day ahead.<br>
        <br>
        Sincerely,<br>
        The Clinic<br.
        <br>
    
    ';

    $attachment = '../qrcodes/' . $appointmentID . '.png';

    sendmail($patient['pemail'], 'Appointment', $message_content, $attachment, true);


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
                                <?php
                                // Fetch the error code from the URL parameter
                                $patientId = isset($_GET['patientId']) ? $_GET['patientId'] : '';

                                // Output the hidden input field with the error code value
                                echo '<input type="hidden" id="patientID" name="patientID" value="' . htmlspecialchars($patientId) . '" >';
                                ?>
								</td>
							</tr>

                            <tr>
								<td class="label-td" colspan="2">
								<label for="patientName" class="form-label">Patient Name:</label>
                                <?php
                                    // Fetch the error code from the URL parameter
                                    $patientName = isset($_GET['patientName']) ? $_GET['patientName'] : '';

                                    // Output the input field with the error code value
                                    echo '<input type="text" id="patientName" name="patientName" value="' . htmlspecialchars($patientName) . '" >';
                                ?>
								</td>
							</tr>

                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="apponum" class="form-label">Appointment Number:</label>
                                    <?php
                                    // Fetch the error code from the URL parameter
                                    $errorCode = isset($_GET['error']) ? $_GET['error'] : '';

                                    // Output the input field with the error code value
                                    echo '<input type="text" id="apponum" name="apponum" value="' . htmlspecialchars($errorCode) . '" readonly>';
                                ?>
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
                            
                           
							<!-- </tr> -->
                            <!-- <tr>
                                <td class="label-td" colspan="2">
                                    <label for="description" class="form-label">Description:</label>
                                   <!-- <input type="text" name="description" class="input-text" required> -->
									<!-- <textarea name="description" class="input-text" ></textarea> -->
                                <!-- </td> -->
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

