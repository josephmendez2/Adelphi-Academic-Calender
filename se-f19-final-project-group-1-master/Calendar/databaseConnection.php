<?php
// databaseConnection.php: Initial testing file for connecting to the database at all. 
  $databaseServerName = "localhost";//insert server port
  $databaseUsername = "root";
  $databasePassword = "";//used for manager and site admin
  $databaseName = "";//insert name from backend group

//to connect to the database
$conn = mysqli_connect($databaseServerName, $databaseUsername, $databasePassword, $databaseName);

//failure message
if (mysqli_connecterrno())
{
  echo "Failed to connect to database: " . mysqli_connect_error());
}
?>
