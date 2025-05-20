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
        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
    

    <script src="https://unpkg.com/html5-qrcode"></script>
    <!-- script src="../qrcode.js"></script> -->

    <style type="text/css">

        .container2 {
            width: 100%;
            margin: 5px;
        }
         
        .container2 h1 {
            color: #ffffff;
        }

        .section {
            background-color: #ffffff;
            padding: 50px 30px;
            border: 1.5px solid #b2b2b2;
            border-radius: 0.25em;
            box-shadow: 0 20px 25px rgba(0, 0, 0, 0.25);
        }
         
        #my-qr-reader {
            padding: 20px !important;
            border: 1.5px solid #b2b2b2 !important;
            border-radius: 8px;
        }
         
        #my-qr-reader img[alt="Info icon"] {
            display: none;
        }
         
        #my-qr-reader img[alt="Camera based scan"] {
            width: 100px !important;
            height: 100px !important;
        }
         
        button {
            padding: 10px 20px;
            border: 1px solid #b2b2b2;
            outline: none;
            border-radius: 0.25em;
            color: white;
            font-size: 15px;
            cursor: pointer;
            margin-top: 15px;
            margin-bottom: 10px;
            background-color: #008000ad;
            transition: 0.3s background-color;
        }
         
        button:hover {
            background-color: #008000;
        }
         
        #html5-qrcode-anchor-scan-type-change {
            text-decoration: none !important;
            color: #1d9bf0;
        }
         
        video {
            width: 100% !important;
            border: 1px solid #b2b2b2 !important;
            border-radius: 0.25em;
        }

    </style>
    
</head>
<body>
    <?php

    //learn from w3schools.com

    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='d'){
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
$query = "SELECT * FROM doctor WHERE demail='$useremail_safe'";
$userrow = $database->query($query);
if ($userrow === false) {
    die("Error executing query: " . $database->error);
}

// Fetch the result
$userfetch = $userrow->fetch_assoc();

// Check if the query returned a result
if ($userfetch !== null) {
    $userid = $userfetch["doctorID"];
    $username = $userfetch["fname"];
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
                    <td class="menu-btn menu-icon-dashbord" >
                        <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">Dashboard</p></a></div></a>
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

                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment menu-active menu-icon-appoinment-active">
                        <a href="scan.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">Scan QR Code</p></a></div>
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
                                
                                <!-- <form action="doctors.php" method="post" class="header-search"> -->
        
                                    <!-- <input type="search" name="search" class="input-text header-searchbar" placeholder="Search Doctor name or Email" list="doctors">&nbsp;&nbsp;
                                     -->
                                    <!-- <?php
                                    //     echo '<datalist id="doctors">';
                                    //     $list11 = $database->query("select  fname,demail from  doctor;");
        
                                    //     for ($y=0;$y<$list11->num_rows;$y++){
                                    //         $row00=$list11->fetch_assoc();
                                    //         $d=$row00["docname"];
                                    //         $c=$row00["docemail"];
                                    //         echo "<option value='$d'><br/>";
                                    //         echo "<option value='$c'><br/>";
                                    //     };
        
                                    // echo ' </datalist>';
                                    // ?>
                                    
                               
                                    <input type="Submit" value="Search" class="login-btn btn-primary-soft btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                                
                                </form> -->
                                
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
                                $doctorrow = $database->query("select  * from  doctor;");
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
                            <td colspan="4" style="text-align: center;">

                                <?php 

                                    if (isset($_REQUEST['appointmentid']) && $_REQUEST['appointmentid'] != '') {

                                        if (strpos($_REQUEST['appointmentid'], 'DEHR-') !== false) {

                                            $data = explode("-", $_REQUEST['appointmentid']);

                                            $appointmentID = $data[1];

                                            echo $appointmentID;

                                            $sql = 'select * from appointment where appID = ' . $appointmentID;
                                            $qry = $database->query($sql);
                                            $appointment = $qry->fetch_assoc();
                                            //print_r($appointment);


                                            $sql = 'select * from patient where patientID = ' . $appointment['patientID'];
                                            $qry = $database->query($sql);
                                            $patient = $qry->fetch_assoc();
                                            //print_r($patient);
                                        
                                            ?>

                                            <h3>Appointmemt</h3>

                                            Appointment details as follows:<br>

                                            <br>
                                            Appointment number:<br>
                                            <span style="font-size: larger;"><?php echo $appointment['apponum']; ?></span><br>
                                            <br>
                                            Patient<br>
                                            <span style="font-size: larger;"><?php echo $patient['patientID']; ?> <?php echo $patient['fullname']; ?></span><br>
                                            <br>

                                            Date/Time<br>
                                            <span style="font-size: larger;"><?php echo date('d M Y', strtotime($appointment['dateTime'])); ?></span><br>
                                            <br>

                                            <?php
                                        }

                                        else {

                                            ?>

                                                You have scanned an invalid QR code.<br>
                                                <br>
                                                Please try again.

                                            <?php

                                        }


                                    }

                                    else {

                                        ?>

                                            <div class="container2">

                                                <table border="0" style="margin: 0; padding: 0;width: 300px; margin: 0 auto;">
                                                    
                                                    <tr>
                                                        <td>
                                                            <p class="header-text">Scan QR Code</p>
                                                        </td>
                                                    </tr>

                                                    <tr>

                                                        <td>

                                                            <div class="section">
                                                                <div id="my-qr-reader">

                                                                </div>
                                                            </div>

                                                        </td>

                                                    </tr>

                                                    <tr>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                </table>

                                                <script src="script.js"></script>

                                            </div>

                                        <?php

                                    }

                                ?>

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