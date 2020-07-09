<?php
 	// api.php: Our REST API for Alexa team to utilize with GET, POST, and DELETE methods
  
  	// Connect to database
	$db=mysqli_connect('localhost','cameronbosch','alliance','f19seaucalendar');

	if ($db->connect_errno) {
	echo "Connect failed: ". $mysqli->connect_error;
	exit();
}
	
	// Switch cases for different REST functions
	$request_method=$_SERVER["REQUEST_METHOD"];
	switch($request_method)
	{
		case 'GET':
			// Retrieve Events
			if(!empty($_GET["eventID"]))
			{
				$eventID=intval($_GET["eventID"]);
				get_events($eventID);
			}
			else
			{
				get_events();
			}
			break;
		case 'POST':
			// Insert an event
			insert_event();
			break;
		case 'DELETE':
			// Delete an event
			$eventID=intval($_GET["eventID"]);
			delete_event($eventID);
			break;
		default:
			// Instance of an Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}

	// POST function
	function insert_event()
	{
		global $db;
		$eventName=$_POST["eventName"];
		$eventDescription=$_POST["eventDescription"];
		$eventDate=$_POST["eventDate"];
		$query="INSERT INTO events SET eventName={$eventName}, eventDescription={$eventDescription}, eventDate={$eventDate}";
		if(mysqli_query($db, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Event Addition Successful.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'Event Addition Failed.'
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	// GET function
	function get_events($eventID=0)
	{
		global $db;
		$query="SELECT * FROM events";
		if($eventID != 0)
		{
			$query.=" WHERE id=".$eventID." LIMIT 1";
		}
		$response=array();
		$result=mysqli_query($db, $query);
		while($row=mysqli_fetch_array($result))
		{
			$response[]=$row;
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}

	// DELETE function
	function delete_event($eventID)
	{
		global $db;
		$query="DELETE FROM events WHERE id=".$eventID;
		if(mysqli_query($db, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'Event Deletion Successful.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'Event Deletion Failed.'
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response);
	}
	
	// Close database connection
	mysqli_close($db);


?>
