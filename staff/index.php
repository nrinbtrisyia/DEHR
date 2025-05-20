<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Dashboard</title>
    <style>
        .dashbord-tables{
            animation: transitionIn-Y-over 0.5s;
        }
        .filter-container{
            animation: transitionIn-Y-bottom  0.5s;
        }
        .sub-table {
    width: 93%;
    margin: auto; 
    text-align: center; 
    border-spacing: 0; 
}


.sub-table td {
    padding: 10px; /* Adjust padding for cells */
}
    </style>
    
    
</head>
<body>
    <?php

    //learn from w3schools.com

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='s'){
            header("location: ../login.php");
    }else{
        $useremail=$_SESSION["user"];
    }
} else {
        header("location: ../login.php");
    }
    

    //import database
    include("../connection.php");

    // Safeguard against SQL injection
$useremail_safe = $database->real_escape_string($useremail);

// Execute the query with error handling
$query = "SELECT * FROM staff WHERE semail='$useremail_safe'";
$userrow = $database->query($query);
if ($userrow === false) {
    die("Error executing query: " . $database->error);
}

// Fetch the result
$userfetch = $userrow->fetch_assoc();

// Check if the query returned a result
if ($userfetch !== null) {
    $userid = $userfetch["staffID"];
    $username = $userfetch["sfname"];
} else {
    // Handle the case where no matching record is found
    // For example, setting default values or showing an error message
    $userid = "Not Found";
    $username = "Not Found";
    // You can also redirect or take other actions as needed
}
    
    
    ?>
    <div class="container">
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
                    <td class="menu-btn menu-icon-dashbord menu-active menu-icon-dashbord-active" >
                        <a href="index.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor ">
                        <a href="record.php" class="non-style-link-menu "><div><p class="menu-text">Record</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-schedule">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">Schedule</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">Appointment</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-patient">
                        <a href="patient.php" class="non-style-link-menu"><div><p class="menu-text">Patients</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="scan.php" class="non-style-link-menu"><div><p class="menu-text">Scan </p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings   ">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body" style="margin-top: 15px">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;" >
                        
                        <tr >
                            
                            <td colspan="2" class="nav-bar" >
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


                                $patientrow = $database->query("select  * from  patient;");
                                $staffrow = $database->query("select  * from  staff;");
                                $appointmentrow = $database->query("select  * from  appointment where dateTime>='$today';");
                                $schedulerow = $database->query("select  * from  schedule where scheduledate='$today';");


                                ?>
                                </p>
                            </td>
                            <td width="10%">
                                <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                            </td>
        
        
                        </tr>
                <tr>
                    <td colspan="4">
                        
                        <center>
                        <table class="filter-container" style="border: none;" border="0">
                            <tr>
                                <td colspan="4">
                                    <p style="font-size: 20px;font-weight:600;padding-left: 12px;">Status</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 25%;">
                                    <div  class="dashboard-items"  style="padding:20px;margin:auto;width:95%;display: flex">
                                        <div>
                                                <div class="h1-dashboard">
                                                    <?php    echo $staffrow->num_rows  ?>
                                                </div><br>
                                                <div class="h3-dashboard">
                                                    Doctors &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                        </div>
                                                <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/doctors-hover.svg');"></div>
                                    </div>
                                </td>
                                <td style="width: 25%;">
                                    <div  class="dashboard-items"  style="padding:20px;margin:auto;width:95%;display: flex;">
                                        <div>
                                                <div class="h1-dashboard">
                                                    <?php    echo $patientrow->num_rows  ?>
                                                </div><br>
                                                <div class="h3-dashboard">
                                                    Patients &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                </div>
                                        </div>
                                                <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/patients-hover.svg');"></div>
                                    </div>
                                </td>
                                <td style="width: 25%;">
                                    <div  class="dashboard-items"  style="padding:20px;margin:auto;width:95%;display: flex; ">
                                        <div>
                                                <div class="h1-dashboard" >
                                                    <?php    echo $appointmentrow ->num_rows  ?>
                                                </div><br>
                                                <div class="h3-dashboard" >
                                                    Appointment &nbsp;&nbsp;
                                                </div>
                                        </div>
                                                <div class="btn-icon-back dashboard-icons" style="margin-left: 0px;background-image: url('../img/icons/book-hover.svg');"></div>
                                    </div>
                                </td>
                                <td style="width: 25%;">
                                    <div  class="dashboard-items"  style="padding:20px;margin:auto;width:95%;display: flex;padding-top:26px;padding-bottom:26px;">
                                        <div>
                                                <div class="h1-dashboard">
                                                    <?php    echo $schedulerow ->num_rows  ?>
                                                </div><br>
                                                <div class="h3-dashboard" style="font-size: 15px">
                                                    Sessions
                                                </div>
                                        </div>
                                                <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/session-iceblue.svg');"></div>
                                    </div>
                                </td>
                                
                            </tr>
                        </table>
                    </center>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <table width="100%" border="0" class="dashbord-tables">
                            <tr>
                                <td>
                                    <p style="padding:10px;padding-left:48px;padding-bottom:0;font-size:23px;font-weight:700;color:var(--primarycolor);text-align:center;">
                                        Upcoming Appointments until Next <?php  
                                        echo date("l",strtotime("+1 week"));
                                        ?>
                                    </p>
                                    <p style="padding-bottom:19px;padding-left:50px;font-size:15px;font-weight:500;color:#212529e3;line-height: 20px;text-align:center;">
                                        Here's Quick access to Upcoming Appointments until 7 days<br>
                                        More details available in @Appointment section.
                                    </p>

                                </td>
                                
                            </tr>
                            <tr>
                                <td width="50%">
                                    <center>
                                        <div class="abc scroll" style="height: 200px;">
                                        <table width="85%" class="sub-table scrolldown" border="0">
                                        <thead>
                                        <tr>    
                                                <th class="table-headin" style="font-size: 12px;">
                                                        
                                                    Appointment number
                                                    
                                                </th>
                                                <th class="table-headin">
                                                    Patient name
                                                </th>
                                                <th class="table-headin">
                                                    
                                                
                                                    Doctor
                                                    
                                                </th>
                                                <th class="table-headin">
                                                    
                                                
                                                    Session
                                                    
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        <?php
                                              $today = date("Y-m-d");
                                              $nextweek = date("Y-m-d", strtotime("+1 week"));
                                      
                                              $sqlmain = "
                                              SELECT 
                                                  appointment.appID,
                                                  schedule.scheduleid,
                                                  schedule.title,
                                                  doctor.fname AS doctor_fname,
                                                  doctor.lname AS doctor_lname,
                                                  patient.fullname AS patient_fullname,
                                                  schedule.scheduledate,
                                                  schedule.scheduletime,
                                                  appointment.apponum,
                                                  appointment.dateTime 
                                              FROM 
                                                  schedule 
                                              INNER JOIN appointment ON schedule.scheduleid = appointment.scheduleid 
                                              INNER JOIN patient ON patient.patientID = appointment.patientID 
                                              INNER JOIN doctor ON schedule.doctorID = doctor.doctorID 
                                              WHERE 
                                                  schedule.scheduledate >= '$today'  
                                                  AND schedule.scheduledate <= '$nextweek' 
                                              ORDER BY 
                                                  schedule.scheduledate DESC";
                                      
                                              $result = $database->query($sqlmain);
                                      
                                              if ($result->num_rows == 0) {
                                                  echo '
                                                  <tr>
                                                      <td colspan="4">
                                                          <br><br><br><br>
                                                          <center>
                                                              <img src="../img/notfound.svg" width="25%">
                                                              <br>
                                                              <p class="heading-main12" style="margin-left: 45px; font-size: 20px; color: rgb(49, 49, 49)">We couldn\'t find anything related to your keywords!</p>
                                                              <a class="non-style-link" href="appointment.php">
                                                                  <button class="login-btn btn-primary-soft btn" style="display: flex; justify-content: center; align-items: center; margin-left: 20px;">&nbsp; Show all Appointments &nbsp;</button>
                                                              </a>
                                                          </center>
                                                          <br><br><br><br>
                                                      </td>
                                                  </tr>';
                                              } else {
                                                  while ($row = $result->fetch_assoc()) {
                                                      $appID = $row["appID"];
                                                      $scheduleid = $row["scheduleid"];
                                                      $title = $row["title"];
                                                      $doctor_fname = $row["doctor_fname"];
                                                      $doctor_lname = $row["doctor_lname"];
                                                      $doctor_name = $doctor_fname . ' ' . $doctor_lname;
                                                      $patient_fullname = $row["patient_fullname"];
                                                      $scheduledate = $row["scheduledate"];
                                                      $scheduletime = $row["scheduletime"];
                                                      $apponum = $row["apponum"];
                                                      $appodate = $row["dateTime"];
                                      
                                                      echo '
                                                      <tr>
                                                          <td style="text-align: center; font-size: 23px; font-weight: 500; color: var(--btnnicetext); padding: 20px;">' . $apponum . '</td>
                                                          <td style="font-weight: 600;">&nbsp;' . substr($patient_fullname, 0, 25) . '</td>
                                                          <td style="font-weight: 600;">&nbsp;' . substr($doctor_name, 0, 25) . '</td>
                                                          <td>' . substr($title, 0, 15) . ' (' . $scheduledate . ' ' . $scheduletime . ')</td>
                                                      </tr>';
                                                  }
                                              }
                                              ?>
                 
                                            </tbody>
                
                                        </table>
                                        </div>
                                        </center>
                                </td>
                                
                
                                                
                                                    
                                            
                                          
                 
                                            </tbody>
                
                                        </table>
                                        </div>
                                        </center>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    
                                </td>
                                
                            </tr>
                        </table>
                    </td>

                </tr>
                        </table>
                        </center>
                        </td>
                </tr>
            </table>
        </div>
    </div>


</body>
</html>