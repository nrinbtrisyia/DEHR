<?php 
    session_start();
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
        
    <title>Login</title>

    <script>
        function forgotPassword() {
            var email = document.getElementsByName('useremail')[0].value;
            if (email) {
                window.location.href = 'reset_password.php?email=' + encodeURIComponent(email);
            } else {
                alert('Please enter your email address.');
            }
        }
    </script>
    
</head>
<body>

<?php
//learn from w3schools.com
//Unset all the server side variables
$_SESSION["user"]="";
$_SESSION["usertype"]="";

// Set the new timezone
date_default_timezone_set('Asia/Kuala_Lumpur');
$date = date('Y-m-d');
$_SESSION["date"]=$date;

//import database
include("connection.php");

if($_POST){
    $email=$_POST['useremail'];
    $password=$_POST['userpassword'];
    $error='<label for="promter" class="form-label"></label>';
    $result= $database->query("select * from webuser where email='$email'");
    if($result->num_rows==1){
        $utype=$result->fetch_assoc()['usertype'];
        if ($utype=='p'){
            //TODO
            $checker = $database->query("select * from patient where pemail='$email' and ppassword='$password'");
            if ($checker->num_rows==1){
                //   Patient dashboard
                $_SESSION['user']=$email;
                $_SESSION['usertype']='p';
                //header('location: patient/index.php');
                echo '<meta http-equiv="refresh" content="0;url=patient/index.php">';

            }else{
                $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
            }
        }elseif($utype=='a'){
            //TODO
            $checker = $database->query("select * from admin where aemail='$email' and apassword='$password'");
            if ($checker->num_rows==1){
                //   Admin dashboard
                $_SESSION['user']=$email;
                $_SESSION['usertype']='a';
                //header('location: admin/index.php');
                echo '<meta http-equiv="refresh" content="0;url=admin/index.php">';
            }else{
                $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
            }
        }elseif($utype=='d'){
            //TODO
            $checker = $database->query("select * from doctor where demail='$email' and dpassword='$password'");
            if ($checker->num_rows==1){
                //   Doctor dashboard
                $_SESSION['user']=$email;
                $_SESSION['usertype']='d';
                //header('location: doctor/index.php');
                echo '<meta http-equiv="refresh" content="0;url=doctor/index.php">';
            }else{
                $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
            }
        }elseif($utype=='s'){
            //TODO
            $checker = $database->query("select * from staff where semail='$email' and spass='$password'");
            if ($checker->num_rows==1){
                //   Staff dashboard
                $_SESSION['user']=$email;
                $_SESSION['usertype']='s';
                //header('location: staff/index.php');
                echo '<meta http-equiv="refresh" content="0;url=staff/index.php">';
            }else{
                $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
            }
        }
    }else{
        $error='<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">We can\'t find any account for this email.</label>';
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
        
    <title>Login</title>
</head>
<body>
    <center>
        <div class="container">
            <table border="0" style="margin: 0;padding: 0;width: 60%;">
                <tr>
                    <td>
                        <p class="header-text">Welcome Back!</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="sub-text">Login with your details to continue</p>
                    </td>
                </tr>
                <form action="" method="POST">
                    <tr>
                        <td class="label-td">
                            <label for="useremail" class="form-label">Email: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td">
                            <input type="email" name="useremail" class="input-text" placeholder="Email Address" required>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td">
                            <label for="userpassword" class="form-label">Password: </label>
                        </td>
                    </tr>
                    <tr>
                        <td class="label-td">
                            <input type="password" name="userpassword" class="input-text" placeholder="Password" required>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <input type="submit" value="Login" class="login-btn btn-primary btn">
                        </td>
                    </tr>
                </form>
                <tr>
                    <td>
                        <br>
                        <!-- Link for Forgot Password -->
                        <a href="javascript:void(0);" onclick="forgotPassword();" class="sub-text">Forgot Password?</a>
                    </td>
                </tr>
            </table>
        </div>
    </center>
</body>
</html>
