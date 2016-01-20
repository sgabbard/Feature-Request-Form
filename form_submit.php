<!DOCTYPE html>
<html lang="en">
	<head>
        <title> Feature Request Form </title>
        <meta charset="utf-8" />
		<link rel="stylesheet" href="feature_request_style.css" type="text/css" media="screen" />
		<?php
			function buildProductList($cat_id) {
			$host="localhost";
			$port=3306;
			$socket="";
			$user="root";
			$password="Password1!";
			$dbname="featureRequest";
			
			$db = new mysqli($host, $user, $password, $dbname, $port, $socket)
				or die ('Could not connect to the database server' . mysqli_connect_error());
			
			$query = "SELECT `request`.`title`, `request`.`description``, `request`.`client`, `request`.`priority`, `request`.`targetDate`, 'request'.'ticketURL', 'request'.'product' FROM `featureRequests`.`request` WHERE `request`.`category` = " .$cat_id. ";";
			
			$result = mysqli_query($db, $query);

			if (!$result) {
				print "Error - the query could not be executed" . mysqli_error($db);
				exit;
			}
	</head>
	