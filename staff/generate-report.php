<?php
// generatereport.php

// Ensure TCPDF library is included correctly
require_once('tcpdf/tcpdf.php');

// Start a new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('Medical Report');
$pdf->SetSubject('Medical Report');
$pdf->SetKeywords('Medical, Report');

// Set default header data (logo, title, and colors)
$pdf->SetHeaderData('DEHR/img/newlogo.png', 30, 'DIALYSIS ELECTRONIC HEALTH RECORD (DEHR)', '', array(0, 64, 255), array(0, 64, 128));

$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// Set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// Set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// Set font
$pdf->SetFont('dejavusans', '', 12);

// Add a page
$pdf->AddPage();

// Retrieve form data
$appointmentId = htmlspecialchars($_POST['appointmentId']);
$patientName = htmlspecialchars($_POST['patientName']);
$doctorName = htmlspecialchars($_POST['doctorName']);
$medicalPlan = htmlspecialchars($_POST['medicalPlan']);
$treatment = htmlspecialchars($_POST['treatment']);
$description = nl2br(htmlspecialchars($_POST['description']));

// Write HTML content with styling
$html = '
<style>
    h1 { text-align: center; color: #003366; font-size: 24px; margin-bottom: 30px; }
    p { font-size: 14px; line-height: 1.5; }
    .info { margin-bottom: 20px; }
    .info p { margin: 5px 0; }
    .info strong { color: #003366; }
    .description { margin-top: 20px; padding: 10px; border: 1px solid #003366; background-color: #f9f9f9; }
</style>
<h1>Medical Report</h1>
<div class="info">
    <p><strong>Appointment ID:</strong> ' . $appointmentId . '</p>
    <p><strong>Patient Name:</strong> ' . $patientName . '</p>
    <p><strong>Doctor Name:</strong> ' . $doctorName . '</p>
    <p><strong>Medical Plan:</strong> ' . $medicalPlan . '</p>
    <p><strong>Treatment:</strong> ' . $treatment . '</p>
</div>
<div class="description">
    <p><strong>Description:</strong></p>
    <p>' . $description . '</p>
</div>
';

// Print HTML content to PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF to browser (inline view)
$pdf->Output('medical_report.pdf', 'I');
?>
