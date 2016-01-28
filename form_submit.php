<!DOCTYPE html>
<html lang="en">
	<head>
        <title> Feature Request Form </title>
        <meta charset="utf-8" />
		<link rel="stylesheet" href="feature_request_style.css" type="text/css" media="screen" />
		<?php
			if ($_POST['_submit_check']) {
			// If validate_form() returns errors, pass them to show_form()
				if ($form_errors = validate_form()) {
					show_form($form_errors);
				} else {
					// The data sent is valid, hence process it...
					insertFeatureRequest();
				} else {
					// The form has not been sent, hence show it again...
					show_form();
				}
			}
			
			function insertFeatureRequest($cat_id) {
				$host="localhost";
				$port=3306;
				$socket="";
				$user="root";
				$password="Password1!";
				$dbname="feature_request_schema";
				
				$db = new mysqli($host, $user, $password, $dbname, $port, $socket)
					or die ('Could not connect to the database server' . mysqli_connect_error());
				
				$query = "SELECT `feature_request`.`title`, `feature_request`.`description``, `feature_request`.`client`, `feature_request`.`priority`, `feature_request`.`target_date`, 'feature_request'.'ticket_URL', 'feature_request'.'product' FROM `feature_request`.`title` WHERE `feature_request`.`title` = " .$cat_id. ";";
				
				$result = mysqli_query($db, $query);

				if (!$result) {
					print "Error - the query could not be executed" . mysqli_error($db);
					exit;
				}
			}
	</head>
	<body>
	</body>
</html>
	