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

if (!isset($_SESSION["personal"])) {
    $_SESSION["personal"] = []; // Initialize the array if not set
}

$fname = $_SESSION['personal']['fname'] ?? ''; // Provide default values if the key is missing
$lname = $_SESSION['personal']['lname'] ?? '';
$dnic = $_SESSION['personal']['dnic'] ?? '';


$error = ''; // Initialize $error variable

if ($_POST) {
    $demail = $_POST['demail'];
    $noPhone = $_POST['noPhone'];
    $role = $_POST['role'];
    $tittle = $_POST['tittle'];
    $dpassword = $_POST['dpassword'];
    $cdpassword = $_POST['cdpassword'];
    
    if ($dpassword == $cdpassword) {
        include("../connection.php");

        // Check if email already exists
        $stmt = $database->prepare("SELECT * FROM webuser WHERE email = ?");
        $stmt->bind_param("s", $demail);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>';
        } else {
            // Insert into doctor table
            $stmt = $database->prepare("INSERT INTO doctor (demail, fname, lname, dpassword, dnic, noPhone, role, tittle) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssssss", $demail, $fname, $lname, $dpassword, $dnic, $noPhone, $role, $tittle);
            $stmt->execute();

            // Insert into webuser table
            $stmt = $database->prepare("INSERT INTO webuser (email, usertype) VALUES (?, 'd')");
            $stmt->bind_param("s", $demail);
            $stmt->execute();

            // Set session variables
            $_SESSION["user"] = $demail;
            $_SESSION["usertype"] = "d";
            $_SESSION["username"] = $fname;

            echo '<script>alert("Record added successfully!"); window.location.href = "patient.php";</script>';
        }
    } else {
        $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Passwords do not match.</label>';
    }
}
?>
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
                <form action="" method="POST" >
                <td class="label-td" colspan="2">
                    <label for="demail" class="form-label">Email: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="email" name="demail" class="input-text" placeholder="Email Address" required>
                </td>
                
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="noPhone" class="form-label">Mobile Number: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="tel" name="noPhone" class="input-text"  placeholder="ex: 0712345678" pattern="[0]{1}[0-9]{9}" >
                </td>
            </tr>
            <td class="label-td" colspan="2">
                    <label for="role" class="form-label">Role: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="name" name="role" class="input-text" placeholder="Role" required>
                </td>
                
            </tr>
            <td class="label-td" colspan="2">
                    <label for="tittle" class="form-label">Title: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="name" name="tittle" class="input-text" placeholder="Title" required>
                </td>
                
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="dpassword" class="form-label">Create New Password: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="password" name="dpassword" class="input-text" placeholder="New Password" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="cdpassword" class="form-label">Confirm Password: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="password" name="cdpassword" class="input-text" placeholder="Confirm Password" required>
                </td>
            </tr>
     
            <tr>
                
                <td colspan="2">
                    <?php echo $error ?>

                </td>
            </tr>
            
            <tr>
                <td>
                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >
                </td>
                <td>
                    <input type="submit" value="Register" class="login-btn btn-primary btn">
                </td>

            </tr>
            

                    </form>
            </tr>
        </table>

    </div>
</center>
</body>
</html>