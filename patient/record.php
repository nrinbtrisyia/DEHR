<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
    <title>Record Management</title>
    <style>
        .popup {
            animation: transitionIn-Y-bottom 0.5s;
        }
        

.sub-table {
    width: 93%; /* Adjust width as needed */
    margin: auto; /* Center the table itself */
    text-align: center; /* Center the content within table cells */
    border-spacing: 0; /* Remove any default spacing */
}

/* Adjustments for table cells if necessary */
.sub-table td {
    padding: 10px; /* Adjust padding for cells */
}

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.7);
            z-index: 999;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .popup {
            background: white;
            padding: 20px;
            border-radius: 5px;
            width: 80%;
            max-width: 600px;
        }
        .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%; /* Could be more or less, depending on screen size */
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    </style>
      <script>

        window.onload = function() {
            var modal = document.getElementById("myModal");
            var btn = document.getElementById("myBtn");
            var span = document.getElementsByClassName("close")[0];
            btn.onclick = function() {
                modal.style.display = "block";
            }
            span.onclick = function() {
                modal.style.display = "none";
            }
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = "none";
                }
            }
        }
    </script>

</head>
<body>

<!-- <button id="myBtn" class="btn-primary">Fetch Record Details</button> -->
<!-- Manual Record Entry Button -->
<!--
<button onclick="location.href='?action=add-record&id=none&error=0'" class="btn-primary">Manual Record Entry</button>
-->
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include("../connection.php"); // Adjust the path as necessary

if (!isset($_SESSION["user"]) || $_SESSION['usertype'] != 'p') {
    header("location: ../login.php");
    exit;
}

$useremail = $_SESSION["user"];
$userrow = $database->query("SELECT * FROM patient WHERE pemail='$useremail'");
$userfetch = $userrow->fetch_assoc();
$userid = $userfetch["patientID"];
$username = $userfetch["fullname"];

$selecttype = "My";
$current = "My patients";
$sqlmain = "SELECT a.*, p.fullname AS patient_name, d.fname AS doctor_name 
          FROM appointment a
          LEFT JOIN patient p ON a.patientID = p.patientID
          LEFT JOIN doctor d ON a.doctorID = d.doctorID
          WHERE a.patientID = '$userid' AND a.doctorID!= 0";
 // Initialize the main SQL query variable




// Execute the main SQL query
$result = $database->query($sqlmain);

// Check if the query was successful
if (!$result) {
    // Get the error message
    $errorMessage = mysqli_error($database);
    
    // Display the error message
    echo "error executing query: " . $errorMessage;
    exit;
}


// Debugging: Check the value of $result
// var_dump($result);





if (isset($_POST['fetchDetails'])) {
    $appID = $_POST['appID'];
    $query = "SELECT patientID, doctorID FROM appointment WHERE appID = ?";
    $stmt = $database->prepare($query);
    $stmt->bind_param("i", $appID);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $patientID = $data['patientID'];
        $doctorID = $data['doctorID'];

        echo '<form method="post" action="">
                <input type="hidden" name="appID" value="' . $appID . '">
                <input type="hidden" name="patientID" value="' . $patientID . '">
                <input type="hidden" name="doctorID" value="' . $doctorID . '">
                <label for="medicalPlan">Medical Plan:</label>
                <input type="text" name="medicalPlan" required>
                <label for="treatment">Treatment:</label>
                <input type="text" name="treatment" required>
                <label for="description">Description:</label>
                <textarea name="description" required></textarea>
                <button type="submit" name="submit-record">Submit Record</button>
            </form>';
    } else {
        echo "No details found for the given Appointment ID.";
    }
}

//if (isset($_GET['action']) && $_GET['action'] == 'add-record') {
    // Display the modal form
    // echo '<div id="myModal" class="modal">
    //         <div class="modal-content">
    //             <span class="close">&times;</span>
    //             <form method="post" action="fetch-appointment.php">
    //                 <label for="fetchid">Enter Appointment ID:</label>
    //                 <input type="text" id="fetchid" name="fetchid" required>
    //                 <button type="submit" name="fetchDetails" class="btn-primary">Fetch Details</button>
    //             </form>
    //         </div>
    //     </div>';

   // echo '<button id="myBtn" style="display:none;">Open Modal</button>';
//}
?>


</body>
</html>



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
                    <td class="menu-btn menu-icon-home " >
                        <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Home</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor menu-active menu-icon-settings-active">
                        <a href="records.php" class="non-style-link-menu  non-style-link-menu-active"><div><p class="menu-text">Record</p></a></div>
                    </td>
                </tr>
                
                <!-- <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">Scheduled Sessions</p></div></a>
                    </td>
                </tr> -->
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">Appointment</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings  ">
                        <a href="settings.php" class="non-style-link-menu "><div><p class="menu-text">Settings</p></a></div>
                    </td>
                </tr>
                
            </table>
        </div>
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr >
                    <td width="13%">

                    <a href="record.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-left:20px;width:125px"><font class="tn-in-text">Back</font></button></a>
                        
                    </td>
                    <td>
                        
                        

                            
                        </form>
                        
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date
                        </p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 
                        date_default_timezone_set('Asia/Kuala_Lumpur');
                        $date = date('Y-m-d');
                        echo $date;
                        ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>
                </tr>
                <tr>
                <td colspan="4">


    <div style="display: flex; margin-top: 40px;">
        <div class="heading-main12" style="margin-left: 30px; font-size: 20px; color: rgb(49, 49, 49); margin-top: 5px;"> Record</div>
</div>
     
    
</td>

</tr>
<?php
    // Example of querying the database and handling errors
    $query = "SELECT a.*, p.fullname AS patient_name, d.fname AS doctor_name 
          FROM appointment a
          LEFT JOIN patient p ON a.patientID = p.patientID
          LEFT JOIN doctor d ON a.doctorID = d.doctorID";

    $list11 = $database->query($query);

    if ($list11 === false) {
        // Handle query execution failure
        die("Database query failed.");
    }

    // Example of initializing variable and accessing its property
    $num_rows = $list11->num_rows ?? 0;

    
?>
                <tr>
                    <td colspan="4" style="padding-top:10px;">
                        <p class="heading-main12" style="margin-left: 45px;font-size:18px;color:rgb(49, 49, 49)"><?php echo $selecttype." Patients (".$list11->num_rows.")"; ?></p>
                    </td>
                    
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:0px;width: 100%;" >
                        <center>
                        <table class="filter-container" border="0" >
 
                        <form action="" method="post">
                        
                        <td  style="text-align: right;">
                        Show Details About : &nbsp;
                        </td>
                        <td width="30%">
                        <select name="showonly" id="showonly" class="box filter-container-items" style="width:90% ;height: 37px;margin: 0;" >
                                    <!-- <option value="" disabled selected hidden><?php echo $current   ?></option><br/> -->
									<!-- <option value="" >Please Select ..</option> -->
                                    <option value="my">Patients Only</option><br/>
                                    <!-- <option value="all">All Patients</option><br/> -->
                                    

                        </select>
                    </td>
                    <td width="12%">
                        <!-- <input type="submit"  name="filter" value=" Filter" class=" btn-primary-soft btn button-icon btn-filter"  style="padding: 15px; margin :0;width:100%">
                       -->
						<input type="button"  Onclick="filter()" name="filter2" value=" Filter" class=" btn-primary-soft btn button-icon btn-filter"  style="padding: 15px; margin :0;width:100%">
                      
					   </form>
                    </td>

                    </tr>
                            </table>

                        </center>
                    </td>
                    
                </tr>
                  
                <tr>
                   <td colspan="4">
                       <center>
                        <div class="abc scroll">
                        <table width="93%" class="sub-table scrolldown"  style="border-spacing:0;">
                        <thead>
                        <tr>
                                <th class="table-headin">
                                Appointment Number
                                </th>
                                <th class="table-headin">
                                Name
                                </th>
                                <th class="table-headin">
                                Doctor Name
                                </th>
                                <th class="table-headin">
                                Medical Plan
                                </th>
                                <th class="table-headin">
                                   Treatment
                                </th>
                                <!-- <th class="table-headin">
                                   Description
                                </th> -->
                                <!-- <th class="table-headin">
                                    Events
                                </tr> -->
                        </thead>
                        <tbody id="displayresults">
                        
                        <?php
// Check if $sqlmain is empty before executing the query
if (!empty($sqlmain)) {
    // Execute the main SQL query
    $result = $database->query($sqlmain);
    
    // Check if the query was successful
    if (!$result) {
        // Display an error message if the query failed
        echo "Error executing query: " . $database->error;
        exit;
    }
    // Process the query result (display records, etc.)
    // You can add your HTML code here to display the records
} else {
    // Display a message if $sqlmain is empty
    echo "SQL query is empty. Check your logic for building the query.";
}

if ($result->num_rows == 0) {
    echo '<tr>
            <td colspan="4">
                <br><br><br><br>
                <center>
                    <img src="../img/notfound.svg" width="25%">
                    <br>
                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We couldn\'t find anything related to your keywords !</p>
                    <a class="non-style-link" onclick="showall()"><button class="login-btn btn-primary-soft btn" style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Patients &nbsp;</button></a>
                </center>
                <br><br><br><br>
            </td>
          </tr>';
} else {
    for ($x = 0; $x < $result->num_rows; $x++) {
        $row = $result->fetch_assoc();
        $appID = $row["appID"];
        $pid = $row["patientID"];
        $name = $row["patient_name"];
        $docname = $row["doctor_name"];
        $med = $row["medicalPlan"];
        $treat = $row["treatment"];
        // $desc = $row["description"];

        $appID = $appID ?? '';
        $name = $name ?? '';
        $docname = $docname ?? '';
        $med = $med ?? '';
        $treat = $treat ?? '';
        // $desc = $desc ?? '';

        echo '<tr>
                <td>&nbsp;' . substr($appID, 0, 12) . '</td>
                <td>' . substr($name, 0, 12) . '</td>
                <td>' . substr($docname, 0, 12) . '</td>
                <td>' . substr($med, 0, 10) . '</td>
                <td>' . substr($treat, 0, 20) . '</td>
               
                <td>
                   
                </td>
              </tr>';
    }
}
?>

                            </tbody>

                        </table>
                        </div>
                        </center>
                   </td> 
                </tr>
            </table>
        </div>
    </div>
	<script>
	function openmodal(){
	}
function gensearch() {
	

  // Get the select element
  var gensearch = document.getElementById("gensearch");  
  // Get the selected option's value
  var gensearch = gensearch.value;
  
  
  var user = '<?php echo $_SESSION["user"]; ?>';
  
  // Create a new XMLHttpRequest object
  var xhr = new XMLHttpRequest();
  
  // Configure it: POST-request for the URL filter.php
  xhr.open('POST', 'search.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  
  // Set up a function that will be called when the request is complete
  xhr.onload = function () {
    if (xhr.status >= 200 && xhr.status < 300) {
      // Parse the JSON response to get the array of HTML strings
		var response = JSON.parse(xhr.responseText);
		
		console.log(response);
		
		// Concatenate the array elements to form a single HTML string
		var html = response.html;
		
		// Update the content of the element with id "displayresults" with the concatenated HTML
		document.getElementById("displayresults").innerHTML = html;
    } else {
      // This will run when there's an error
      console.error('Request failed with status:', xhr.status);
    }
  };
  
  // Set up a function that will be called if there's an error
  xhr.onerror = function () {
    console.error('Request failed');
  };
  
  // Send the request with the selected value as data
  xhr.send('gensearch=' + gensearch + '&user=' + user );
}</script>
	<script>
	function showall(){
		 // Value to select
    var valueToSelect = "all";
    
    // Select the option with the specified value
    var selectBox = document.getElementById("showonly");
    for (var i = 0; i < selectBox.options.length; i++) {
        if (selectBox.options[i].value == valueToSelect) {
            selectBox.options[i].selected = true;
			filter();
            break;
        }
    }
	}
function deletethis(id) {
    if (confirm("Are you sure you want to delete this record?")) {
        var xhr = new XMLHttpRequest();
        xhr.open('DELETE', 'delete-appointment.php?id=' + id, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                alert('Record deleted successfully');
              location.href = location.href;
            } else if (xhr.readyState == 4 && xhr.status != 200) {
                alert('Error deleting record');
            }
        };
        xhr.send();
    }
}

function filter() {
	

  // Get the select element
  var selectBox = document.getElementById("showonly");  
  // Get the selected option's value
  var selectedValue = selectBox.value;
  
  if(selectedValue == ""){
	alert('Please Select atleast 1 filter..');
	return;
  }
  
  
  var user = '<?php echo $_SESSION["user"]; ?>';
  
  // Create a new XMLHttpRequest object
  var xhr = new XMLHttpRequest();
  
  // Configure it: POST-request for the URL filter.php
  xhr.open('POST', 'filter.php', true);
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  
  // Set up a function that will be called when the request is complete
  xhr.onload = function () {
    if (xhr.status >= 200 && xhr.status < 300) {
      // Parse the JSON response to get the array of HTML strings
		var response = JSON.parse(xhr.responseText);
		
		console.log(response);
		
		// Concatenate the array elements to form a single HTML string
		var html = response.html;
		
		// Update the content of the element with id "displayresults" with the concatenated HTML
		document.getElementById("displayresults").innerHTML = html;
    } else {
      // This will run when there's an error
      console.error('Request failed with status:', xhr.status);
    }
  };
  
  // Set up a function that will be called if there's an error
  xhr.onerror = function () {
    console.error('Request failed');
  };
  
  // Send the request with the selected value as data
  xhr.send('selected=' + selectedValue + '&user=' + user );
}


</script>
    <?php


