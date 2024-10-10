<?php

define('DB_SERVER','localhost');
define('DB_USERNAME','csci488_fall24');
define('DB_PASSWORD','writeCode24');
define('DB_DATABASE','csci488_fall24');

$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

//next time: add a message instead of echoing, otherwise it prints before the html
//output here
//<!doctype html>
//webpage still renders, but the message is at the top of the page
//<?= is shortcut for <?php echo
$message = "";

if ($mysqli->connect_errno) {
    $message = "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit;
}

$animal_name = $_GET['name'];
$datetime = date("Y-m-d H:i:s");
$now = time();
$query = "SELECT * FROM cherepanov_animals WHERE animal_name = '$animal_name'";
$result = $mysqli->query($query);

if ($result->num_rows > 0) {
    $message = "$animal_name already exists in the database, not added!";
}
elseif ($animal_name != ""){
    $query = "INSERT INTO cherepanov_animals (animal_id, animal_name, animal_timestamp, animal_datetime, animal_int) VALUES (NULL,'$animal_name', '$datetime','$datetime' , $now)";
    $result = $mysqli->query($query);
    if ($result) {
        $message = "$animal_name added to the database";
    }
    else {
        $message = "Error adding $animal_name to the database, please try again!";
    }
}
else {
	$message = "No animal name provided, please try again!";
}

/*
Notes:
  NULL for the auto-increment field
  There is also an animal_timestamp field set to default to CURRENT_TIMESTAMP, hence no value sent.
*/


$query = "SELECT * FROM cherepanov_animals ORDER BY animal_id ASC";
$result = $mysqli->query($query);

$num_rows =  $result->num_rows;
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Basic Database Code</title>
	</head>
	<body>
		<div>
			<?=$message?>
		</div>
		<br /><br />
		Database table listing.
		<br /><br />
		<?=$num_rows?> rows in database.
		<br /><br />


		<!--
		  Each loop pass below "fetches" one database $row out of the mysql $result set.
		  Each fetched $row is an associative array whose keys are the database table column names.
		-->

		<table width="" cellspacing="0" cellpadding="5">
			<? if ($num_rows>0) { ?>
				<? while ( $row = $result->fetch_assoc() ) { ?>
					<tr  valign="top">
						<td>
							<?=$row['animal_id']?>
						</td>
						<td>
							<?=$row['animal_name']?>
						</td>
						<td>
							<?=$row['animal_timestamp']?>
						</td>
						<td>
							<?php
                            date("ga - M j, o",strtotime($row['animal_datetime']));
                            ?>
						</td>
						<td>
							<?=$row['animal_int']?>
						</td>
					</tr>
				<? } // while ?>
			<? } // if ?>
		</table>

	</body>
</html>
