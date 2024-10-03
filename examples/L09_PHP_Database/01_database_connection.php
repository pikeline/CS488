<?
/*

Note:
The Web-based database GUI is located at
https://csci.lakeforest.edu/cscidbgui/
The below user name and password will log you into that.
*/

define('DB_SERVER','localhost');
define('DB_USERNAME','csci488_fall24');
define('DB_PASSWORD','writeCode24');
define('DB_DATABASE','csci488_fall24');

$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit;
}

$animal_names = array('aardvark','wildebeest','bandicoot','muskox');
$random_animal = $animal_names[mt_rand(0,3)];

$query = "INSERT INTO knuckles_animals (animal_id,animal_name) VALUES (NULL,'$random_animal')";
$result = $mysqli->query($query);

/*
Notes:
  NULL for the auto-increment field
  There is also an animal_timestamp field set to default to CURRENT_TIMESTAMP, hence no value sent.
*/


$query = "SELECT * FROM knuckles_animals ORDER BY animal_id ASC";
$result = $mysqli->query($query);

$num_rows =  $result->num_rows;
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Basic Database Code</title>
	</head>
	<body>

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
					</tr>
				<? } // while ?>
			<? } // if ?>
		</table>

	</body>
</html>