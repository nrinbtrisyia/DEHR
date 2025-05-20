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
    width: 93%; 
    margin: auto; 
    text-align: center; 
    border-spacing: 0; 
}


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

            filter();
        }
    </script>

</head>
<body>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include("../connection.php"); // Adjust the path as necessary

if (!isset($_SESSION["user"]) || $_SESSION['usertype'] != 'd') {
    header("location: ../login.php");
    exit;
}

$useremail = $_SESSION["user"];
$userrow = $database->query("SELECT * FROM doctor WHERE demail='$useremail'");
$userfetch = $userrow->fetch_assoc();
$userid = $userfetch["doctorID"];
$username = $userfetch["fname"];

$selecttype = "My";
$current = "My patients";
$sqlmain = ""; // Initialize the main SQL query variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["search"])) {
        $keyword = $_POST["search12"];
        $sqlmain = "SELECT * FROM patient WHERE pemail='$keyword' OR fullname LIKE '%$keyword%';";
        $selecttype = "Search Results";
    } elseif (isset($_POST["filter"]) && isset($_POST["showonly"]) && $_POST["showonly"] == 'all') {
        $sqlmain = "SELECT * FROM appointment JOIN patient ON patient.patientID=appointment.patientID JOIN schedule ON schedule.scheduleid=appointment.scheduleid JOIN doctor ON doctor.doctorID = appointment.doctorID!=0";
        $selecttype = "All Patients";
		
		echo $sqlmain;
    }
}



// Adjust the query for "My Record" based on the logged-in doctor's ID
if ($current == "My patients") {
    $sqlmain = "SELECT * FROM appointment 
                JOIN patient ON patient.patientID = appointment.patientID 
                JOIN schedule ON schedule.scheduleid = appointment.scheduleid 
                JOIN doctor ON doctor.doctorID = appointment.doctorID 
                WHERE doctor.doctorID = $userid AND appointment.doctorID != 0";
} else if ($current == "All Patients") {
    $sqlmain = "SELECT * FROM appointment 
                JOIN patient ON patient.patientID = appointment.patientID 
                JOIN schedule ON schedule.scheduleid = appointment.scheduleid 
                JOIN doctor ON doctor.doctorID = appointment.doctorID 
                WHERE appointment.doctorID != 0";
}


// Execute the main SQL query
if ($sqlmain != "") {
    $result = $database->query($sqlmain);
    if (!$result) {
        echo "Error executing query: " . $database->error;
        exit;
    }
 
    echo '<table>';
    while ($row = $result->fetch_assoc()) {
        // Display each record here
        echo '<tr><td>' . $row['patientID'] . '</td></tr>';
    }
    echo '</table>';
}

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
    echo '<div id="myModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form method="post" action="fetch-appointment.php">
                    <label for="fetchid">Enter Appointment Number:</label>
                    <input type="text" id="fetchid" name="fetchid" required>
                    <button type="submit" name="fetchDetails" class="btn-primary">Fetch Details</button>
                </form>
            </div>
        </div>';

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
                    <td class="menu-btn menu-icon-dashbord" >
                        <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">Dashboard</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                <td class="menu-btn menu-icon-doctor menu-active menu-icon-doctor-active">
                        <a href="record.php" class="non-style-link-menu  non-style-link-menu-active"><div><p class="menu-text"> Record</p></a></div>
                    </td>
                </tr>
                
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-schedule">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text"> Schedule</p></div></a>
                    </td>
                </tr>

                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">Appointment</p></a></div>
                    </td>
                </tr>

                <tr class="menu-row" >
                <td class="menu-btn menu-icon-patient">
                        <a href="patient.php" class="non-style-link-menu"><div><p class="menu-text"> Patients</p></div></a>
                    </td>
                </tr>

                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="scan.php" class="non-style-link-menu"><div><p class="menu-text">Scan QR Code</p></a></div>
                    </td>
                </tr>
                
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings   ">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">Settings</p></a></div>
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
                        
                        <form action="" method="post" class="header-search">

                            <!-- <input type="search" name="search12" class="input-text header-searchbar" id="gensearch" placeholder="Search Patient name or Email" list="patient">&nbsp;&nbsp; -->
                            <input type="text" name="gensearch"class="input-text header-searchbar" id="gensearch" placeholder="Search Patient name or Email" >&nbsp;&nbsp;
                            <?php
                                echo '<datalist id="patient">';
                                $list11 = $database->query($sqlmain);
                                for ($y=0;$y<$list11->num_rows;$y++){
                                    $row00=$list11->fetch_assoc();
                                    $d=$row00["fullname"];
                                    $c=$row00["pemail"];
                                    echo "<option value='$d'><br/>";
                                    echo "<option value='$c'><br/>";
                                };

                            echo ' </datalist>';
?>
                            <a type="button"  Onclick="gensearch()"  value="Search" name="search" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;"> Search </a>
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
        <div class="heading-main12" style="margin-left: 30px; font-size: 20px; color: rgb(49, 49, 49); margin-top: 5px;">Add Record</div>
        <div style="margin-left: 20px;"> <!-- Add margin here -->
            <button id="myBtn" class="login-btn btn-primary btn button-icon">Add Patient's Record</button>
            <!-- <a href="add-appointment3.php?action=add-record&id=none&error=0" class="non-style-link"><button class="login-btn btn-primary btn button-icon" style="margin-left:25px;background-image: url('../img/icons/add.svg');">New Patient Record</button></a> -->
        </div>
    </div>
</td>

</tr>
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
                                    <option value="my">My Patients Only</option><br/>
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
                                <th class="table-headin">
                                   Description
                                </th>
                                <th class="table-headin">
                                    Events
                                </tr>
                        </thead>
                        <tbody id="displayresults">
                        
                            <?php

                                
                                $result= $database->query($sqlmain);
                                if($result->num_rows==0){
                                    echo '<tr>
                                    <td colspan="4">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    
                                    <br>
                                    <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">We couldn\'t find anything related to your keywords !</p>
                                    <a class="non-style-link" Onclick="showall()"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-left:20px;">&nbsp; Show all Patients &nbsp;</button>
                                    </a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';
                                    
                                }
                                else{
                                for ( $x=0; $x<$result->num_rows;$x++){
                                    $row=$result->fetch_assoc();
                                    $appID=$row["apponum"];
                                    $pid=$row["patientID"];
                                    $name=$row["fullname"];
                                    $docname=$row["fname"];
                                    $med=$row["medicalPlan"];
                                    $treat=$row["treatment"];
                                    $desc=$row["description"];
                                  
                                    
                                    echo '<tr>
                                        <td> &nbsp;'.
                                        substr($appID,0,12)
                                        .'</td>
                                        <td>
                                        '.substr($name,0,12).'
                                        </td>
                                        <td>
                                        '.substr($docname,0,12).'
                                        </td>
                                        <td>
                                            '.substr($med,0,10).'
                                        </td>
                                        <td>
                                        '.substr($treat,0,20).'
                                         </td>
                                         <td>
                                         '.substr($desc,0,20).'
                                          </td>
                                        
                                        <td >
                                        <div style="display:flex;justify-content: center;">
                                        
                                        <a href="edit-appointment.php?action=view&id='.$appID.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">View</font></button></a>
										&nbsp;
										<a Onclick="deletethis('.$appID.')" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-delete" style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Remove</font></button></a>
                                       
                                        </div>
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

filter();
showall();
</script>
    <?php


