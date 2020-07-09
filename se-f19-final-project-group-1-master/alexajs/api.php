<?php
  // Connect to database
	$db=mysqli_connect('localhost','cameronbosch','alliance','f19seaucalendar');

	if ($db->connect_errno) {
	echo "Connect failed: ". $mysqli->connect_error;
	exit();
}
	
	$request_method=$_SERVER["REQUEST_METHOD"];
	switch($request_method)
	{
		case 'GET':
			if (isset($_GET['eventName']))
				get_events($_GET['eventName']);
			else get_events(null);
			break;
		case 'POST':
			// Insert event
			insert_event();
			break;
		case 'DELETE':
			// Delete event
			break;
		default:
			// Invalid Request Method
			header("HTTP/1.0 405 Method Not Allowed");
			break;
	}

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
				'status_message' =>'Event Added Successfully.'
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
		echo json_encode($response, JSON_PRETTY_PRINT);
	}
	function get_events($evt)
	{
		global $db;
		$response=array();
		if (empty($evt)){
			$query="SELECT * FROM events";
			$result=mysqli_query($db, $query);
			while($row=mysqli_fetch_array($result)){
			$response[]=$row;
		}}
		else 
			$query="SELECT * FROM events WHERE eventName='$evt'";
			$result=mysqli_query($db, $query);
			$row=mysqli_fetch_array($result);
			$response[]=$row;
		
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	}
	function delete_event($eventID)
	{
		global $db;
		$query="DELETE FROM events WHERE id=".$eventID;
		if(mysqli_query($db, $query))
		{
			$response=array(
				'status' => 1,
				'status_message' =>'event Deleted Successfully.'
			);
		}
		else
		{
			$response=array(
				'status' => 0,
				'status_message' =>'event Deletion Failed.'
			);
		}
		header('Content-Type: application/json');
		echo json_encode($response, JSON_PRETTY_PRINT);
	}
	
	// Close database connection
	mysqli_close($db);


?>
