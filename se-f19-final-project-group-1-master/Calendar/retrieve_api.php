<?php

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

$db = new mysqli("localhost", "cameronbosch", "alliance", "f19seaucalendar");
if ($db->connect_errno) {
	echo "Connect failed: ". $mysqli->connect_error;
	exit();
}
$sql = "Select * from events where eventDate = '$eventDate'";
$result = $db->query($sql);


$table = $result->fetch_all();
echo "<table>";
foreach ($table as $row) {
	echo "<tr>";
	foreach ($row as $col) {
		echo "<td>$col</td>";
		}
	echo "</tr>";
	}
	echo "</table>";

$db->close();

?>