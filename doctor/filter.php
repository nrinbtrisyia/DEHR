<?php
session_start();
include("../connection.php"); // Adjust the path as necessary

if (!isset($_POST['user'])) {
    echo json_encode(array('message' => 'Error: User parameter not set'));
    exit;
}

$user_email = $_POST['user'];
$conn = $database;


if ($conn->connect_error) {
    echo json_encode(array('message' => 'Connection failed: ' . $conn->connect_error));
    exit;
}

// SQL query to select data for a specific email
$sql = "SELECT doctorID FROM doctor WHERE demail = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$result = $stmt->get_result();

$doctorID = NULL;

// Check if a row was returned
if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    $doctorID = $row['doctorID'];
} else {
    echo json_encode(array('message' => 'No results or multiple results'));
    exit;
}

$stmt->close(); // Close the previous statement

if ($doctorID !== NULL) {
    // Prepare base condition for filtering
    $whereClause = " WHERE appointment.doctorID != 0"; // Base condition

    // If a specific doctor is selected
    if (isset($_POST['selected']) && $_POST['selected'] !== 'all') {
        $whereClause .= " AND appointment.doctorID = ?";
    }

  
    $sql = "SELECT appointment.appID, patient.fullname, doctor.fname, appointment.medicalPlan, appointment.treatment, appointment.description 
            FROM appointment 
            LEFT JOIN patient ON patient.patientID = appointment.patientID
            LEFT JOIN doctor ON doctor.doctorID = appointment.doctorID
            $whereClause";
    
    $stmt = $conn->prepare($sql);

    if (isset($_POST['selected']) && $_POST['selected'] !== 'all') {
        $stmt->bind_param("i", $doctorID);
    }


    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $data = array();
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }

        $html = '';
        foreach ($data as $row) {
            $html .= "<tr>";
            $html .= "<td>" . htmlspecialchars($row["appID"]) . "</td>";
            $html .= "<td>" . htmlspecialchars($row["fullname"]) . "</td>";
            $html .= "<td>" . htmlspecialchars($row["fname"]) . "</td>";
            $html .= "<td>" . htmlspecialchars($row["medicalPlan"]) . "</td>";
            $html .= "<td>" . htmlspecialchars($row["treatment"]) . "</td>";
            $html .= "<td>" . htmlspecialchars($row["description"]) . "</td>";
            $html .= '<td>';
            $html .= '<div style="display:flex;justify-content: center;">';
            $html .= '<a href="edit-appointment.php?action=view&amp;id=' . htmlspecialchars($row["appID"]) . '" class="non-style-link">';
            $html .= '<button class="btn-primary-soft btn button-icon btn-view" style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;">';
            $html .= '<font class="tn-in-text">View</font></button></a>';
            $html .= '&nbsp;<a onclick="deletethis(' . htmlspecialchars($row["appID"]) . ')" class="non-style-link"><button class="btn-primary-soft btn button-icon btn-delete" style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">Remove</font></button></a>';
            $html .= '</div>';
            $html .= '</td>';
            $html .= "</tr>";
        }

        $json = json_encode(array(
            'html' => $html,
            'sql' => $sql
        ));

        echo $json;
    } else {
        echo json_encode(array('message' => 'No results'));
    }

    $stmt->close();
}

$conn->close();
?>
