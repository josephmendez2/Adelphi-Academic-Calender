<?php

// add_api.php: Legacy API for adding events, kept for documentation purposes.
class Event {
	// Properties
	private $eventName;
	private $eventDescription;
	private $eventDate;

	// Constructor
	function __construct($name, $description, $date) {
    $this->eventName = $name;
	$this->eventDescription = $description;
	$this->eventDate = $date;
  }

	// Methods
	function getEventName() {
		return $this->eventName;
	}
	function getEventDescription() {
		return $this->eventDescription;
	}
	function getEventDate() {
		return $this->eventDate;
	}
	function setEventName(newEventName) {
		$this->eventName = newEventName;
	}
	function setEventDescription(newEventDescription) {
		$this->eventDescription = newEventDescription;
	}
	function setEventName(newEventDate) {
		$this->eventDate = newEventDate;
	}
}

// Database connection
$db = new mysqli("localhost", "cameronbosch", "alliance", "f19seaucalendar");
if ($db->connect_errno) {
	echo "Connect failed: ". $mysqli->connect_error;
	exit();
}

// Fill in with values from form.
var theEvent = new Event() 
$sql = "INSERT INTO events (eventName, eventDescription, eventDate)
VALUES ('$theEvent->getEventName()', '$theEvent->getEventDescription()', '$theEvent->getEventDate()')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error adding to table: " . $sql . "<br>" . $conn->error;
}

$db->close();

?>
