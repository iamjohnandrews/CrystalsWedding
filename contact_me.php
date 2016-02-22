<?php
if($_POST)
{
	$to_Email   	= "sample@email.com"; //Put your Recieving Email
	$subject        = 'Enquiry Recieved from Wedding Website'; //Put Your Custom Subject line 
	
	
    if(!isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') {
	
		$output = json_encode(
		array(
			'type'=>'error', 
			'text' => 'Request must come from Ajax'
		));
		die($output);
    } 
	
	//check $_POST vars are set, exit if any missing
	if(!isset($_POST["fullname"]) || !isset($_POST["email"]) || !isset($_POST["member"]) || !isset($_POST["event"]))
	{
		$output = json_encode(array('type'=>'error', 'text' => 'Input fields are empty!'));
		die($output);
	}

	//Sanitize input data using PHP filter_var().
	$user_Name        = filter_var($_POST["fullname"], FILTER_SANITIZE_STRING);
	$user_Email       = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
	$member     = filter_var($_POST["member"], FILTER_SANITIZE_STRING);
	$event			  = filter_var($_POST["event"], FILTER_SANITIZE_STRING);
	

	//proceed with PHP email.
	$headers = 'Content-Type: text/html; charset=utf-8\r\n' .
	'From: '.$user_Email.'' . "\r\n" .
	'Reply-To: '.$user_Email.'' . "\r\n" .
	'X-Mailer: PHP/' . phpversion();
	
	$sentMail = @mail($to_Email, $subject, "Name: ".$user_name."<br>Email:".$user_Email.'<br>Members: '.$member."<BR>Events :".$event, $headers);

	if(!$sentMail)
	{
		$output = json_encode(array('error'=>true, 'text' => 'Could not send mail! Please check your PHP mail configuration.'));
		die($output);
	}else{
		$output = json_encode(array('error'=>false, 'text' => 'Your message has been sent'));
		die($output);
	}
}
?>