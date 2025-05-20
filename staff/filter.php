<?php
session_start();
include("../connection.php");

if (isset($_POST['user'])) {
    $user_email = $_POST['user'];
} else {
    echo json_encode(array('message' => 'User not found'));
    exit();
}

$conn = $database;

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$selected = $_POST['selected'];
$whereClause = " WHERE appointment.doctorID != 0";

if ($selected != "all") {
    $doctorID = str_replace('doctor_', '', $selected);
    $whereClause = " WHERE appointment.doctorID = " . intval($doctorID);
}

$sql = "SELECT appointment.*, patient.*, doctor.* 
FROM appointment 
LEFT JOIN patient ON patient.patientID = appointment.patientID
LEFT JOIN doctor ON doctor.doctorID = appointment.doctorID" . $whereClause;

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = array();

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

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

    echo json_encode(array(
        'html' => $html,
        'sql' => $sql
    ));
} else {
    echo json_encode(array('message' => 'No results'));
}

$conn->close();
?>
