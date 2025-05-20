<?php
session_start();
$_SESSION["user"] = "";
$_SESSION["usertype"] = "";

date_default_timezone_set('Asia/Kuala_Lumpur');
$date = date('Y-m-d');
$_SESSION["date"] = $date;

// Import database
include("connection.php");

// Process the form submission if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = isset($_GET['email']) ? $_GET['email'] : '';
    $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';

    // Validate email and new password
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format";
    } elseif (empty($new_password)) {
        $error_message = "New password cannot be empty";
    } else {
        // Check if the email exists in the database
        $query = "SELECT * FROM webuser WHERE email = '$email'";
        $result = $database->query($query);

        if ($result && $result->num_rows == 1) {
            // Update the password in the database
            $update_query = "UPDATE webuser SET password = '$new_password' WHERE email = '$email'";
            $update_result = $database->query($update_query);

            if ($update_result) {
                // Password updated successfully
                $success_message = "Your password has been successfully updated.";

                $row = $result->fetch_assoc();
                $usertype = $row['usertype'];

                switch ($usertype) {
                    case 'd':
                        $update_query = "UPDATE doctor SET dpassword = '$new_password' WHERE demail = '$email'";
                        $database->query($update_query);
                        break;
                    case 'p':
                        $update_query = "UPDATE patient SET ppassword = '$new_password' WHERE pemail = '$email'";
                        $database->query($update_query);
                        break;
                    case 's':
                        $update_query = "UPDATE staff SET spass = '$new_password' WHERE semail = '$email'";
                        $database->query($update_query);
                        break;
                    default:
                        
                        break;
                }
            } else {
                $error_message = "Error updating password.";
            }
        } else {
            $error_message = "No account found with that email address.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>

</head>
<body>
    <h2>Reset Password</h2>
    <?php if(isset($success_message)): ?>
        <p><?php echo $success_message; ?></p>
    <?php elseif(isset($error_message)): ?>
        <p><?php echo $error_message; ?></p>
    <?php else: ?>
        <form action="" method="POST">
            
            <label for="new_password">Enter your new password:</label><br>
            <input type="password" name="new_password" placeholder="New Password" required><br>
            <input type="submit" value="Reset Password">
        </form>
    <?php endif; ?>
</body>
</html>
