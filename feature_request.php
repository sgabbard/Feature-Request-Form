<!DOCTYPE html>
<html lang="en">
	<head>
        <title> Feature Request Form </title>
        <meta charset="utf-8" />
		<link rel="stylesheet" href="feature_request_style.css" type="text/css" media="screen" />
	</head>
	<body>
		
<?php
	// define variables and set to empty values
	$titleErr = $descErr = $priorityErr = $targetDateErr = $ticketUrlErr = "";
	$title = $desc = $client = $priority = $targetDate = $ticketURL = $client = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		
		$client = $_POST("client");
		$product = $_POST("product");
		
	   if (empty($_POST["title"])) {
		 $titleErr = "Title is required";
	   } else {
		 $title = test_input($_POST["title"]);
		 // check if title only contains letters, numbers and whitespace
		 if (!preg_match("/^[-a-zA-Z0-9 .]+$/",$title)) {
		   $titleErr = "Only letters, numbers, and white space allowed"; 
		 }
	   }
	   
	   if (empty($_POST["desc"])) {
		 $descErr = "Description is required";
	   } else {
		 $desc = test_input($_POST["desc"]);
	   }
	  
	   //need to add more checking here to change the priority of other jobs if this is changed
	   if (empty($_POST["priority"])) {
		 $priorityErr = "Priority level is required";
	   } else {
		 $priority = test_input($_POST["priority"]);
		 // check if priority is only numbers
		 if (!preg_match("/^[0-9]*$/",$priority)) {
		   $priorityErr = "Only numbers allowed"; 
		 }
		 //check for negative numbers
		 if ($priority < 0) {
			 $priorityErr = "Only positive priorities allowed";
		 }
	   }
		
		if (empty($_POST["targetDate"])) {
		 $targetDateErr = "Target date is required";
	   } else {
		 $targetDate = test_input($_POST["targetDate"]);
	   }
	   
	   if (empty($_POST["ticketURL"])) {
		 $ticketUrlErr = "Ticket URL required";
	   } else {
		 $ticketURL = test_input($_POST["ticketURL"]);
		 // check if URL address syntax is valid 
		 if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$ticketURL)) {
		   $ticketUrlErr = "Invalid URL"; 
		 }
	   }
	}

	function test_input($data) {
	   $data = trim($data);
	   $data = stripslashes($data);
	   $data = htmlspecialchars($data);
	   return $data;
	}
	
	function insertFeatureRequest() {
		$host="localhost";
		$port=3306;
		$socket="";
		$user="root";
		$password="Password1!";
		$dbname="featureRequest";
		
		$dbConn = new mysqli($host, $user, $password, $dbname, $port, $socket)
			or die ('Could not connect to the database server' . mysqli_connect_error());
		
		//get the records that have equal or greater priority
		$query = "SELECT `feature_request`.`title`, `feature_request`.`description`, `feature_request`.`client`, `feature_request`.`priority`, `feature_request`.`target_date`, `feature_request`.`ticket_URL`, `feature_request`.`product` FROM `feature_request_schema`.`feature_request` WHERE `feature_request`.`priority` >= " .$priority;
		
		$result = mysqli_query($dbConn, $query);

		if (!$result) {
			print "Error - the query could not be executed" . mysqli_error($dbConn);
			exit;
		}
		
		//loop through the results and increment the priorities by 1
		while ($row = mysqli_fetch_array($result, MYSQL_NUM)) {
			$reqTitle = $row[0];
			$recPriority = $row[4];
			$sql = "UPDATE `feature_request`.`title` SET `feature_request`.`priority`=" .$recPriority + 1. "' WHERE `feature_request`.`title`= " .$reqTitle. ";"

			if ($dbConn->query($sql) !== TRUE) {
				echo "Error updating record: " . $dbConn->error;
			}
		}
			
		//insert the new  record
		$sql = "INSERT INTO `feature_request_schema`.`feature_request` (`feature_request`.`title`, `feature_request`.`description`, `feature_request`.`client`, `feature_request`.`priority`, `feature_request`.`target_date`, `feature_request`.`ticket_URL`, `feature_request`.`product`) VALUES ($title, $desc, $client, $priority, $targetDate, $ticketURL, $product)". ";"
		if (!mysqli_query($conn, $sql)) {
			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
		} 
		
		//close the connection
		$dbConn->close();
	}
	
	function validate_form() {
		if ($titleErr == "" || $descErr == "" || $priorityErr == "" || $targetDateErr == "" || $ticketUrlErr == "") {
			//submit to the database 
			insertFeatureRequest($cat_id);
			
			//navigate to the success page
			header("Location: /form_submit.php");
			exit;
		}
		else {
			echo htmlspecialchars($_SERVER["PHP_SELF"]);
		}
	}
?>		
		<div id="page" class="layout">
			<h2>Feature Request Form</h2>
			<span class="error">* required field</span>
			<form method="post" action="<?php validate_form();?>">
				<table>
					<tr>
					   <td>Title: </td>
					   <td> 
					   <input type="text" name="title" class="label"/>
					   <span class="error">* <?php echo $titleErr;?></span>
					   </td>
				   </tr>
					<tr>
					   <td>Description: </td>
					   <td> 
					   <textarea type="text" cols="30" rows="4" name="desc" class="label"></textarea>
					   <span class="error">* <?php echo $descErr;?></span>
					   </td>
					</tr>   
					<tr>
					   <td>Client:</td>	   
						<td>
						<select name="client" class="label"/>
							<option value="clientA">Client A</option>
							<option value="clientB">Client B</option>
							<option value="clientC">Client C</option>	
						</select>
						</td>
				   </tr>
				   <tr>
					   <td>Client Priority: </td>
					   <td>
					   <input type="number" name="priority" class="label"/>
					   <span class="error">* <?php echo $priorityErr;?></span>
					   </td>
				   </tr>
				   <tr>
					   <td>Target Date: </td>
					   <td>
					   <input type="date" name="targetDate" class="label" value="<?php echo date('Y-m-d'); ?>"/>
					   <span class="error">* <?php echo $targetDateErr;?></span>
					   </td>
				   </tr>
				   <tr>
					   <td>Ticket URL: </td>
					   <td>
					   <input type="text" name="ticketURL" class="label">
					   <span class="error">* <?php echo $ticketUrlErr;?></span>
					   </td>
				   </tr>
				   <tr>
					   <td>Product Area:</td>		   
						<td>
						<select name="product" class="label">
							<option value="policies">Policies</option>
							<option value="billing">Billing</option>
							<option value="claims">Claims</option>	
							<option value="reports">Reports</option>	
						</select>
						</td>				   
				   <tr>
					   <td><input type="submit" name="submit" value="Submit"/> </td>
					</tr>
				</table>
		   </form>
		</div>
    </body>
</html>