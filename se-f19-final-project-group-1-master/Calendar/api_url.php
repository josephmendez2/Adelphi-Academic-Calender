<?php
	$connection=mysqli_connect('localhost','cameronbosch','alliance','f19seaucalendar');
	$url = 'http://compsci.adelphi.edu/~cameronbosch/';
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_HTTPGET, true);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response_json = curl_exec($ch);
	curl_close($ch);
	$response=json_decode($response_json, true);
	
	mysqli_close($connection);
?>