<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/signup.css">
        
    <title>Register</title>
    <style>
        .container{
            animation: transitionIn-X 0.5s;
        }
        
body{
    margin: 2%;
    background-color: #F6F7FA;
}
.container{
    width: 45%;
    background-color: white;
    border: 1px solid rgb(235, 235, 235);
    border-radius: 8px;
    margin: 0;
    padding: 0;
    box-shadow: 0 3px 5px 0 rgba(240, 240, 240, 0.3);
    animation: transitionIn-Y-over 0.5s;

}
td{
    text-align: center;

}
.header-text{
    font-weight: 600;
    font-size: 30px;
    letter-spacing: -1px;
    margin-bottom: 10px;
}

.sub-text{
    font-size: 15px;
    color: rgb(138, 138, 138);
}

.form-label{
    color: rgb(44, 44, 44);
    text-align: left;
    font-size: 14px;
}
.label-td{
    text-align: left;
    padding-top: 10px;
}

.hover-link1{
    font-weight: bold;
}


.hover-link1:hover{
    opacity: 0.8;
    transition: 0.5s;


}.login-btn{
    margin-top: 15px;
    margin-bottom: 15px;
    width: 100%;
}

    </style>
</head>
<body>

<?php

session_start();

$error = ''; // Initialize $error variable

if ($_POST) {
    $sfname = $_POST['sfname'];
    $slname = $_POST['slname'];
    $semail = $_POST['semail'];
    $snoPhone = $_POST['snoPhone'];
    $spass = $_POST['spass'];
    $cspass = $_POST['cspass'];
    
    if ($spass == $cspass) {
        include("../connection.php");

        // Check if email already exists
        $stmt = $database->prepare("SELECT * FROM webuser WHERE email = ?");
        $stmt->bind_param("s", $semail);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">An account already exists for this Email address.</label>';
        } else {
            // Insert into staff table
            $stmt = $database->prepare("INSERT INTO staff (semail, sfname, slname, snoPhone, spass) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $semail, $sfname, $slname, $snoPhone, $spass);
            $stmt->execute();

            // Insert into webuser table
            $stmt = $database->prepare("INSERT INTO webuser (email, usertype) VALUES (?, 's')");
            $stmt->bind_param("s", $semail);
            $stmt->execute();

            // Set session variables
            $_SESSION["user"] = $semail;
            $_SESSION["usertype"] = "s";
            $_SESSION["username"] = $sfname;

            echo '<script>alert("Record added successfully!"); window.location.href = "patient.php";</script>';
        }
    } else {
        $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Passwords do not match.</label>';
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
    <link rel="stylesheet" href="css/signup.css">
    <title>Register</title>
    <style>
        .container {
            animation: transitionIn-X 0.5s;
        }
        body {
            margin: 2%;
            background-color: #F6F7FA;
        }
        .container {
            width: 45%;
            background-color: white;
            border: 1px solid rgb(235, 235, 235);
            border-radius: 8px;
            margin: 0;
            padding: 0;
            box-shadow: 0 3px 5px 0 rgba(240, 240, 240, 0.3);
            animation: transitionIn-Y-over 0.5s;
        }
        td {
            text-align: center;
        }
        .header-text {
            font-weight: 600;
            font-size: 30px;
            letter-spacing: -1px;
            margin-bottom: 10px;
        }
        .sub-text {
            font-size: 15px;
            color: rgb(138, 138, 138);
        }
        .form-label {
            color: rgb(44, 44, 44);
            text-align: left;
            font-size: 14px;
        }
        .label-td {
            text-align: left;
            padding-top: 10px;
        }
        .hover-link1 {
            font-weight: bold;
        }
        .hover-link1:hover {
            opacity: 0.8;
            transition: 0.5s;
        }
        .login-btn {
            margin-top: 15px;
            margin-bottom: 15px;
            width: 100%;
        }
    </style>
</head>
<body>
    <center>
    <div class="container">
        <table border="0" style="width: 69%;">
            <tr>
                <td colspan="2">
                    <!-- <p class="header-text">Let's Get Started</p>
                    <p class="sub-text">It's Okey, Now Create User Account.</p> -->
                </td>
            </tr>
            <tr>
                <form action="" method="POST">
                <td class="label-td" colspan="2">
                    <label for="semail" class="form-label">Email: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="email" name="semail" class="input-text" placeholder="Email Address" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="sfname" class="form-label">First Name: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="text" name="sfname" class="input-text" placeholder="First Name" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="slname" class="form-label">Last Name: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="text" name="slname" class="input-text" placeholder="Last Name" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="snoPhone" class="form-label">Mobile Number: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="tel" name="snoPhone" class="input-text" placeholder="ex: 0712345678" pattern="[0]{1}[0-9]{9}">
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="spass" class="form-label">Create New Password: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="password" name="spass" class="input-text" placeholder="New Password" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="cspass" class="form-label">Confirm Password: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="password" name="cspass" class="input-text" placeholder="Confirm Password" required>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php echo $error; ?>
                </td>
            </tr>
            <tr>
                <td>
                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn">
                </td>
                <td>
                    <input type="submit" value="Register" class="login-btn btn-primary btn">
                </td>
            </tr>
            </form>
        </table>
    </div>
    </center>
</body>
</html>
