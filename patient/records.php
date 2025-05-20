<?php
    // Start session
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION["user"]) || $_SESSION['usertype'] !== 'p') {
        header("location: ../login.php");
        exit; // Exit to prevent further execution
    }

    // Import database connection
    include("../connection.php");

    // Fetch user details
    $useremail = $_SESSION["user"];
    $userrow = $database->query("SELECT * FROM patient WHERE pemail='$useremail'");
    $userfetch = $userrow->fetch_assoc();
    $userid = $userfetch["patientID"];
    $username = $userfetch["fullname"];

    // Fetch patient records from the appointment table joined with the schedule table
    $sql = "SELECT a.appID, s.scheduledate, s.scheduletime, d.fname, a.medicalPlan, a.treatment 
            FROM appointment a 
            INNER JOIN schedule s ON a.scheduleid = s.scheduleid 
            INNER JOIN doctor d ON a.doctorID = d.doctorID";

    $result = $database->query($sql);

    // Check if there are any records
    if ($result->num_rows > 0) {
?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Patient Records</title>
            <link rel="stylesheet" href="../css/main.css">
            <link rel="stylesheet" href="../css/admin.css">
        </head>
        <body>
            <div class="container">
                <div class="menu">
                <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-left:20px" >
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo substr($username,0,13)  ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                <a href="../logout.php" ><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                    </table>
                    </td>
                
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-home " >
                        <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Home</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="record.php" class="non-style-link-menu"><div><p class="menu-text">Record</p></a></div>
                    </td>
                </tr>
                
                <!-- <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">Scheduled Sessions</p></div></a>
                    </td>
                </tr> -->
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">Appointment</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings  menu-active menu-icon-settings-active">
                        <a href="settings.php" class="non-style-link-menu  non-style-link-menu-active"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
                
            </table>
        </div>
        <div class="dash-body" style="margin-top: 15px">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;" >
                        
                        <tr >
                            
                        <td width="13%" >
                    <a href="record.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-left:12px;font-weight: 600;">Patien Record</p>
                                           
                    </td>
                    
                            <td width="15%">
                                <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                                    Today's Date
                                </p>
                                <p class="heading-sub12" style="padding: 0;margin: 0;">
                                    <?php 
                                date_default_timezone_set('Asia/Kuala_Lumpur');
        
                                $today = date('Y-m-d');
                                echo $today;


                                // $patientrow = $database->query("select  * from  patient;");
                                // $doctorrow = $database->query("select  * from  doctor;");
                                // $appointmentrow = $database->query("select  * from  appointment where dateTime>='$today';");
                                // $schedulerow = $database->query("select  * from  schedule where scheduledate='$today';");


                                ?>
                                </p>
                            </td>
                            <td width="10%">
                                <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                            </td>
        
        
                        </tr>
                </div>


                
                <div class="dash-body">
                    <h2>Patient Records</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Appointment ID</th>
                                <th>Schedule Date</th>
                                <th>Schedule Time</th>
                                <th>Doctor Name</th>
                                <th>Medical Plan</th>
                                <th>Treatment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                // Output data of each row
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <tr>
                                        <td><?php echo $row["appID"]; ?></td>
                                        <td><?php echo $row["scheduledate"]; ?></td>
                                        <td><?php echo $row["scheduletime"]; ?></td>
                                        <td><?php echo $row["fname"]; ?></td>
                                        <td><?php echo $row["medicalPlan"]; ?></td>
                                        <td><?php echo $row["treatment"]; ?></td>
                                    </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </body>
        </html>
<?php
    } else {
        // No records found
        echo "No patient records found.";
    }
?>
