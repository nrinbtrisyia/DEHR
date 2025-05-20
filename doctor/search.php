<?php
//print_r($_POST);

session_start();
include("../connection.php"); // Adjust the path as necessary


if(isset($_POST['gensearch'])){
$gensearch = $_POST['gensearch'];
}else{
 echo 'error';
}
$conn = $database;

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

    // SQL query to select data for a specific doctorID
	
	$where = '1=1 ';
	$where .= "AND (patient.pemail LIKE '%$gensearch%' OR patient.fullname LIKE '%$gensearch%')";
	
    $sql = "SELECT * FROM appointment 
	LEFT JOIN
patient ON patient.patientID = appointment.patientID
LEFT JOIN
doctor ON doctor.doctorID = appointment.doctorID
	
	WHERE $where";
	
	
    
    // Execute query
    $result = $conn->query($sql);
    
    // Check if any rows were returned
    if ($result->num_rows > 0) {
        // Initialize an array to hold the data
        $data = array();
        
        // Fetch each row and add it to the data array
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
		// Assuming $data is the array containing the fetched data
		$html = '';
		foreach ($data as $row) {
			$html .= "<tr>";
			$html .= "<td>" . $row["appID"] . "</td>";
			$html .= "<td>" . $row["fullname"] . "</td>";
			$html .= "<td>" . $row["fname"] . "</td>";
			$html .= "<td>" . $row["medicalPlan"] . "</td>";
			$html .= "<td>" . $row["treatment"] . "</td>";
			$html .= "<td>" . $row["description"] . "</td>";
			$html .= '<td>';
			$html .= '<div style="display:flex;justify-content: center;">';
			$html .= '<a href="edit-appointment.php?action=view&amp;id=' . $row["appID"] . '" class="non-style-link">';
			$html .= '<button class="btn-primary-soft btn button-icon btn-view" style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">';
			$html .= '<font class="tn-in-text">View</font></button></a>';
			$html .= '&nbsp;<a onclick="deletethis(' . $row["appID"] . ')" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-delete" style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Remove</font></button></a>';
			$html .= '</div>';
			$html .= '</td>';
			$html .= "</tr>";

		
		}

		// Encode the HTML as JSON
		$json = json_encode(array(
		
		'html' => $html,
		'sql' => $sql
		
		));

		// Output the JSON
		echo $json;
		
    } else {
        echo json_encode(array('message' => 'No results'));
    }







// Close connection
$conn->close();

?>