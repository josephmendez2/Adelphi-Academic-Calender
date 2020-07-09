<?php
  	// getEvents.php: API to retrieve the events in our database
  
    header("Access-Control-Allow-Origin: *");
    
	// Instantiations
    $EVENT_ID = 'eventID';
    $EVENT_NAME = 'eventName';
    $EVENT_DATE = 'eventDate';
    $EVENT_DESCRIPTION = 'eventDescription';
    $EVENT_TERM_ID = 'eventTermID';

	// Database connection
    $connect = new PDO('mysql:host=localhost;dbname=f19seaucalendar', 'frankcolasurdo', 'frcolsefp');

    $data = array();

    $query = "SELECT * FROM events";

    $statement = $connect->prepare($query);

    $statement->execute();

    $result = $statement->fetchAll();

	// Put fetched events into array
    foreach($result as $row)
    {
    $data[] = array(
    "$EVENT_ID" => $row["$EVENT_ID"],
    "$EVENT_NAME"   => $row["$EVENT_NAME"],
    "$EVENT_DESCRIPTION" => $row["$EVENT_DESCRIPTION"],
    "$EVENT_DATE" => $row["$EVENT_DATE"],
    "$EVENT_TERM_ID" => $row["$EVENT_TERM_ID"]
    );
    }

	// Return json encoded data
    echo json_encode($data);
?>
