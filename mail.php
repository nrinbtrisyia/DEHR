<?php

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'assets/PHPMailer/src/Exception.php';
	require 'assets/PHPMailer/src/PHPMailer.php';
	require 'assets/PHPMailer/src/SMTP.php';

	function sendmail($to, $subject, $body, $attachment='', $html=false) {

		global $db;
		global $send_email;

		$mail = new PHPMailer(); // create a new object
	
		$mail->IsSMTP(); // enable SMTP
	
		$mail->SMTPDebug = 0; // debugging: 1 = errors and messages, 2 = messages only
	
		$mail->SMTPAuth = true; // authentication enabled
	
		$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail
	
		$mail->Host = "51.79.189.120";
	
		$mail->Port = 587; // or 587
	
		$mail->IsHTML($html);
	
		$mail->Username = "noreply@snazy.xyz";
	
		$mail->Password = '1qaz2wsx#EDC$RFV';
	
		$mail->SetFrom("noreply@snazy.xyz","noreply@snazy.xyz");
	
		$mail->Subject = $subject;
	
		$mail->Body = $body;

		$mail->AddAddress($to);
	
		if ($attachment != '') {
			//$mail->addAttachment($attachment);
			$mail->AddEmbeddedImage($attachment, "my-attach", "qrcode");		

		}

		$mail->smtpConnect(
		    array(
		        "ssl" => array(
		            "verify_peer" => false,
		            "verify_peer_name" => false,
		            "allow_self_signed" => true
		        )
		    )
		); 	

		if(!$mail->Send()) {

			return $mail->ErrorInfo;

		} else {

			return 'OK';

		}	
	
	}
	

	/*
	function sendmail($to, $subject, $body, $html=false) {

		global $db;
		global $send_email;

		$mail = new PHPMailer(); // create a new object
		$mail->IsSMTP(); // enable SMTP
		$mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
		$mail->SMTPAuth = false; // authentication enabled
		$mail->SMTPSecure = 'tls'; // secure transfer enabled REQUIRED for Gmail

		$mail->Host = "snazy.xyz";
		$mail->Port = 587; // or 587
		$mail->IsHTML($html);
		$mail->Username = "noreply@snazy.xyz";
		$mail->Password = '1qaz2wsx#EDC$RFV';
		$mail->SetFrom("noreply@snazy.xyz","DEHR Appointment");
		$mail->Subject = $subject;
		$mail->Body = $body;
		$mail->AddAddress($to);

		$mail->smtpConnect(
		    array(
		        "ssl" => array(
		            "verify_peer" => false,
		            "verify_peer_name" => false,
		            "allow_self_signed" => true
		        )
		    )
		); 	
		
		if(!$mail->Send()) {
			return $mail->ErrorInfo;
		} else {
			return 'OK';
		}	

	}
	*/


	function messagecontent($message) {

		$email = $message;
		return $email;

	}

?>