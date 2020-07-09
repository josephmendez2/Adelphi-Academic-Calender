<?php
  	// removeEvents.php: preliminary API framework for deleting events via the web interface 
  
    // Allow computers on other domains not from our adelphi server to make HTTP POST and GET requests.
    header("Access-Control-Allow-Origin: *");
	
	$EVENT_NAME = 'eventName';
	$EVENT_DATE = 'eventDate';
    
    // PHP doesn't understand JSON sent by JavaScript. Convert JSON for PHP to understand.
	$_POST = json_decode(file_get_contents('php://input'), true);

	$connect = new PDO('mysql:host=localhost;dbname=f19seaucalendar', 'frankcolasurdo', 'frcolsefp');
	
	$query = "
		DELETE FROM Customers WHERE	eventName = :$eventName AND eventDate = :$eventDate;
	";

	$statement = $connect->prepare($query);
	$statement->execute($data);
?>
