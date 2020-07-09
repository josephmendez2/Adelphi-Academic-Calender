<?php
  	// addEvents.php: Current API for the addition of events using the web-interface.
  
    // Allow computers on other domains not from our adelphi server to make HTTP POST and GET requests.
    header("Access-Control-Allow-Origin: *");
	
	// Instantiations 
	$EVENT_NAME = 'eventName';
	$EVENT_DATE = 'eventDate';
	$EVENT_DESCRIPTION = 'eventDescription';
	$EVENT_TERM_ID = 'eventTermID';
    
    // PHP doesn't understand JSON sent by JavaScript. Convert JSON for PHP to understand.
	$_POST = json_decode(file_get_contents('php://input'), true);

	// Database connection
	$connect = new PDO('mysql:host=localhost;dbname=f19seaucalendar', 'frankcolasurdo', 'frcolsefp');
	
	// Insert into database
	$query = "
		INSERT INTO events ($EVENT_NAME, $EVENT_DATE, $EVENT_DESCRIPTION, $EVENT_TERM_ID) 
		VALUES 			   (:$EVENT_NAME, :$EVENT_DATE, :$EVENT_DESCRIPTION, :$EVENT_TERM_ID)
	";

	// Array creation
	$data = array(
		'eventName' => $_POST["$EVENT_NAME"],
		'eventDate' => $_POST["$EVENT_DATE"],
		'eventDescription' => $_POST["$EVENT_DESCRIPTION"],
		'eventTermID' => $_POST["$EVENT_TERM_ID"],
	);

	// Execution of insertion
	$statement = $connect->prepare($query);
	$statement->execute($data);
?>
