<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/main.css"> 
    <link rel="stylesheet" href="../css/admin.css">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    
    <title>Session</title>
    <style>
        /* Animations */
        @keyframes transitionIn-Y-over {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes transitionIn-Y-bottom {
            from {
                transform: translateY(20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Main Styles */
        .dashbord-tables{
            animation: transitionIn-Y-over 0.5s;
        }

        .filter-container{
            animation: transitionIn-Y-bottom 0.5s;
        }

        .sub-table{
            animation: transitionIn-Y-bottom 0.5s;
        }

        /* Custom Styles */
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

        button {
            margin-top: 15px;
            margin-bottom: 10px;
        }
    </style>

    <script src="https://unpkg.com/html5-qrcode"></script>
</head>
<body>
    <?php
    session_start();

    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='d'){
            header("location: ../login.php");
        } else {
            $useremail=$_SESSION["user"];
        }
    } else {
        header("location: ../login.php");
    }

    if($_POST){
        //import database
        include("../connection.php");
        $title=$_POST["title"];
        $doctorname=$_POST["doctorname"];
        $nop=$_POST["nop"];
        $date=$_POST["date"];
        $time=$_POST["time"];

        echo $doctorname . " " . $date . " " . $time;

        $sql = "SELECT doctorID FROM doctor WHERE fname = ?";
        $stmt = $database->prepare($sql);
        $stmt->bind_param("s", $doctorname);
        $stmt->execute();
        $result = $stmt->get_result();
        $doctor = $result->fetch_assoc();

        if (!$doctor) {
            // Doctor not found, handle the error gracefully
            echo '<div class="container my-4">';
            echo '<div class="alert alert-danger" role="alert">';
            echo '<h4 class="alert-heading">Add Session Error</h4>';
            echo '<p>Doctor name not found. Please check the doctor name and try again.</p>';
            echo '<hr>';
            echo '<a href="add-session.php" class="btn btn-secondary">Back to Add Session</a>';
            echo '</div>';
            echo '</div>';
            exit;
        }

        $doctorID = $doctor['doctorID'];

        $sql = '
            select * from schedule where 1
            and doctorID = "' . $doctorID . '" 
            and scheduledate = "' . $date . '" 
            and scheduletime = "' . $time . '" 
        ';

        $result = $database->query($sql);

        if ($result->num_rows > 0) {
            // records available, check if slot is still available
            ?>
            <div class="container my-4">
                <div class="alert alert-danger" role="alert">
                    <h4 class="alert-heading">Add Session Error</h4>
                    <h5>Session name: <?php echo $title; ?></h5>
                    <p>A session with the same doctor / date / time exists, please select another session.</p>
                    <hr>
                    <p class="mb-0">Suggestions are as per below. Select an alternative suitable session.</p>
                </div>


                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Alternative Session</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 0;
                        $suggestions = 5;

                        while ($i < $suggestions) {
                            $validslot = false;
                            $newdate = $date;
                            $newtime = $time;

                            do {
                                // if time is 9:00am then select time 2:00pm
                                if ($time == '09:00') {
                                    $newtime = '14:00';
                                } 
                                // else go to 9:00am on the next day
                                elseif ($time == '14:00') {
                                    $newtime = '09:00';
                                    $newdate = date('Y-m-d', strtotime($newdate . ' +1 day')); //suppose to be $newdate bukan $date, sebelum ni $data so dia tak fetch properly
                                }

                                $sql2 = '
                                    select * from schedule where 1
                                    and doctorID = "' . $doctorID . '" 
                                    and scheduledate = "' . $newdate . '" 
                                    and scheduletime = "' . $newtime . '" 
                                ';

                                $result2 = $database->query($sql2);
                                if ($result2->num_rows > 0) {
                                    // records available too, select next slot
                                    $validslot = false;
                                } else {
                                    $validslot = true;
                                }

                                $date = $newdate;
                                $time = $newtime;
                            } while (!$validslot);

                            echo '<tr>';
                            echo '<td>' . $newdate . ' ' . $newtime . '</td>';
                            echo '<td>';
                            echo '<form name="form' . $i . '" method="post" action="add-session.php" style="display: none;">';
                            echo '<input name="title" value="' . $title . '">';
                            echo '<input name="doctorname" value="' . $doctorname . '">';
                            echo '<input name="nop" value="' . $nop . '">';
                            echo '<input name="date" value="' . $newdate . '">';
                            echo '<input name="time" value="' . $newtime . '">';
                            echo '</form>';
                            echo '<button type="button" onclick="document.form' . $i . '.submit();" class="btn btn-primary">Select this schedule</button>';
                            echo '</td>';
                            echo '</tr>';

                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
                <a href="schedule.php" class="btn btn-secondary">Back to Schedule</a>
            </div>
            <?php
        } else {
            $sql="insert into schedule (doctorID,title,scheduledate,scheduletime,nop) values ($doctorID,'$title','$date','$time',$nop);";
            $result= $database->query($sql);
            header("location: schedule.php?action=session-added&title=$title");
        }
    }
    ?>
</body>
</html>
