<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/login.css">
        
    <title>Login</title>

    
    
</head>
<body>

<?php

session_start();
include("connection.php");

$appointment_id = '';
$appointment = '';

if ($_GET) {

    $appointment_id = $_GET['id'];
    $sql = 'select * from appointment where appID = ' . $appointment_id;
    $query = $database->query($sql);

    if ($query->num_rows > 0) {
        $appointment = $query->fetch_assoc();

    }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/login.css">
        
    <title>Appointment Info</title>
</head>
<body>
    <center>
        <div class="container">
            <table border="0" style="margin: 0;padding: 0;width: 60%;">
                
                <tr>
                    <td>
                        <p class="header-text">Your Appointment</p>
                    </td>
                </tr>

                <?php 

                    if ($appointment_id != '') {
                        
                        ?>
                            <tr>
                                <td style="text-align: center;"> 

                                    <img src="qrcodes/<?php echo $appointment_id; ?>.png" style="width: 200px; height: auto;">

                                </td>
                            </tr>

                        <?php 

                        if ($appointment != '') {

                            ?>

                                <tr>
                                    <td>

                                        <table style="width:100% important;">
                                            <tr>
                                                <td style="text-align: left;">Patient</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left;">Date</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left;">Time</td>
                                                <td></td>
                                            </tr>
                                            <tr>
                                                <td style="text-align: left;">Doctor</td>
                                                <td></td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>

                            <?php 
                        
                        }

                        else {

                            ?>

                                <tr>
                                    <td>There is no appointment data.</td>
                                </tr>

                            <?php 

                        }


                    }

                    else {

                        ?>

                            <tr>
                                <td style="text-align: center;">Appointment ID does not exist</td>
                            </tr>

                        <?php 
                    }

                ?>
                <tr>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </div>
    </center>
</body>
</html>
