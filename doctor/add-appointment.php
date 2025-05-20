<?php
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


if ($_POST) {
    // Import database
    include("../connection.php");
    
    // Retrieve form data
    $patientID = $_POST["patientID"];
    $apponum = $_POST["apponum"];
    $scheduleid = $_POST["scheduleid"];
    $dateTime = $_POST["dateTime"];
    $doctorID = $_POST["doctorID"];
    $description = $_POST["description"];
    
    // Insert appointment into the database
    $sql = "INSERT INTO appointment (patientID, apponum, scheduleid, dateTime, doctorID, description) VALUES ($patientID, $apponum, $scheduleid, '$dateTime', $doctorID, '$description')";
    $result = $database->query($sql);
    
    // Redirect to schedule page with a success message
    header("location: schedule.php?action=appointment-added");
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
            <a class="close" href="schedule.php">&times;</a> 
            <div style="display: flex;justify-content: center;">
                <div class="abc">
                    <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                        <tr>
                            <td>
                                <p style="padding: 0;margin: 0;text-align: left;font-size: 25px;font-weight: 500;">Add New Appointment</p><br>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-td" colspan="2">
                                <form action="add-appointment.php" method="POST" class="add-new-form">
                                    <label for="patientID" class="form-label">Patient ID:</label>
                                    <input type="text" name="patientID" class="input-text" required><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="apponum" class="form-label">Appointment Number:</label>
                                    <input type="text" name="apponum" class="input-text" required><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="scheduleid" class="form-label">Schedule ID:</label>
                                    <input type="text" name="scheduleid" class="input-text" required><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="dateTime" class="form-label">Date and Time:</label>
                                    <input type="datetime-local" name="dateTime" class="input-text" required><br>
                                </td>
                            </tr>
                            <tr>
								<td class="label-td" colspan="2">
								<label for="scheduleID" class="form-label">Doctor ID:</label>
										<select name="doctorID" class="input-text" required>
											<?php foreach ($doctor as $key => $row) : ?>
												<option value="<?php echo $row['doctorID']; ?>"><?php echo $row['doctorID']; ?> <?php echo $row['fname']; ?></option>
											<?php endforeach; ?>
										</select>
								</td>
							</tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="description" class="form-label">Description:</label>
                                    <input type="text" name="description" class="input-text" required><br>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="submit" value="Add Appointment" class="login-btn btn-primary btn" name="appointmentsubmit">
                                </td>
                            </tr>
                        </form>
                    </tr>
                </table>
            </div>
        </div>
    </center>
    <br><br>
</div>
</div>

</body>
</html>
