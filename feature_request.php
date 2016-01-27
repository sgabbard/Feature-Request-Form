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
	$title = $desc = $priority = $targetDate = $ticketURL = "";

	if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
?>		
		<div id="page" class="layout">
			<h2>Feature Request Form</h2>
			<span class="error">* required field</span>
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
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