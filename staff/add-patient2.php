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

//learn from w3schools.com
//Unset all the server side variables

session_start();

$_SESSION["user"]="";
$_SESSION["usertype"]="s";

// Set the new timezone
date_default_timezone_set('Asia/Kuala_Lumpur');
$date = date('Y-m-d');

$_SESSION["date"]=$date;


//import database
include("../connection.php");


$error = ''; // Initialize $error variable

if($_POST){
    // Your form submission handling code here


    $result= $database->query("select * from webuser");

    $fullname=$_SESSION['personal']['fullname'];
    // $lname=$_SESSION['personal']['lname'];
    // $name=$fname." ".$lname;
    $paddress=$_SESSION['personal']['paddress'];
    $pnic=$_SESSION['personal']['pnic'];
    $dob=$_SESSION['personal']['dob'];
    $email=$_POST['pemail'];
    $noPhone=$_POST['noPhone'];
    $ppassword=$_POST['ppassword'];
    $cpassword=$_POST['cpassword'];
    
    if ($ppassword == $cpassword) {
        $sqlmain = "SELECT * FROM webuser WHERE email = ?";
        $stmt = $database->prepare($sqlmain);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 1) {
            $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Already have an account for this Email address.</label>';
        } else {
            //TODO
            $database->query("INSERT INTO patient (pemail, fullname, ppassword, paddress, pnic, dob, noPhone) 
                  VALUES ('$email', '$fullname', '$ppassword', '$paddress', '$pnic', '$dob', '$noPhone')");
    
            $database->query("INSERT INTO webuser (email, usertype) VALUES ('$email', 'p')");
    
            // Set session variables
            $_SESSION["user"] = $email;
            $_SESSION["usertype"] = "p";
            $_SESSION["username"] = $fullname;
    
            echo '<script>alert("Record added successfully!"); window.location.href = "patient.php";</script>';
        }
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
                    <label for="pemail" class="form-label">Email: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="email" name="pemail" class="input-text" placeholder="Email Address" required>
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
            <tr>
                <td class="label-td" colspan="2">
                    <label for="ppassword" class="form-label">Create New Password: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="password" name="ppassword" class="input-text" placeholder="New Password" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="cpassword" class="form-label">Confirm Password: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="password" name="cpassword" class="input-text" placeholder="Confirm Password" required>
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