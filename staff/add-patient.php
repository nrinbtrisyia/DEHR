
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


$_SESSION["user"]="";
$_SESSION["usertype"]="s";

// Set the new timezone
date_default_timezone_set('Asia/Kuala_Lumpur');
$date = date('Y-m-d');

$_SESSION["date"]=$date;




if($_POST){

    

    $_SESSION["personal"]=array(
        'fullname'=>$_POST['fullname'],
        // 'lname'=>$_POST['lname'],
        'paddress'=>$_POST['paddress'],
        'pnic'=>$_POST['pnic'],
        'dob'=>$_POST['dob']
    );


    print_r($_SESSION["personal"]);
    header("location: add-patient2.php");




}

?>


    <center>
    <div class="container">
        <table border="0">
            <tr>
                <td colspan="2">
                    <!-- <p class="header-text">Let's Get Started</p> -->
                    <p class="sub-text">Add Personal Details to Continue</p>
                </td>
            </tr>
            <tr>
                <form action="" method="POST" >
                <td class="label-td" colspan="2">
                    <label for="name" class="form-label">Name: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td">
                    <input type="text" name="fullname" class="input-text" placeholder="First Name" required>
                </td>
                <!-- <td class="label-td">
                    <input type="text" name="lname" class="input-text" placeholder="Last Name" required>
                </td> -->
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="paddress" class="form-label">Address: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="text" name="paddress" class="input-text" placeholder="Address" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="pnic" class="form-label">NIC: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="text" name="pnic" class="input-text" placeholder="NIC Number" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <label for="dob" class="form-label">Date of Birth: </label>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                    <input type="date" name="dob" class="input-text" required>
                </td>
            </tr>
            <tr>
                <td class="label-td" colspan="2">
                </td>
            </tr>

            <tr>
                <td>
                    <input type="reset" value="Reset" class="login-btn btn-primary-soft btn" >
                </td>
                <td>
                    <input type="submit" value="Next" class="login-btn btn-primary btn">
                </td>

            </tr>
            

                    </form>
            </tr>
        </table>

    </div>
</center>
</body>
</html>