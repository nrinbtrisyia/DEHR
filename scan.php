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
        
    <title>Scan QR Code</title>

    <script src="https://unpkg.com/html5-qrcode"></script>

    <style type="text/css">

        .container {
            width: 100%;
            max-width: 500px;
            margin: 5px;
        }
         
        .container h1 {
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
    <center>
        <div class="container">
            <table border="0" style="margin: 0;padding: 0;width: 60%;">
                
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
        </div>
    </center>

    <script src="script.js"></script>

</body>
</html>
