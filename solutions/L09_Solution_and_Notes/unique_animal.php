<?
define('DB_SERVER','localhost');
define('DB_USERNAME','csci488_fall23');
define('DB_PASSWORD','DbFun2023');
define('DB_DATABASE','csci488_fall23');

$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit;
}

$animal = $_GET['animal'];  // from query string like: ?animal=Wunderpus

// Trimming user entered data is usually a good idea
if (trim($animal) == '') {
  $message = "Please submit a non-empty animal name.";
}
else {

  $query = "SELECT * FROM knuckles_animals WHERE animal_name='$animal'";
  $result = $mysqli->query($query);

  $num_rows =  $result->num_rows;

  if ($num_rows == 0) {
    // $animal does not yet exist in DB, so add it

    $query = "INSERT INTO knuckles_animals VALUES (NULL,'$animal')";
    $result = $mysqli->query($query);
    $message = "<b>$animal</b> was added to the database.";
  }
  else {
    $message = "<b>$animal</b> already exists in the database, so it was not added.";
  }

}

$query = "SELECT * FROM knuckles_animals ORDER BY animal_id ASC";
$result = $mysqli->query($query);
$num_rows =  $result->num_rows;

/*
HW Notes:

1)
Why not just do the following in the above code?
echo "<b>$animal</b> was added to the database.";

Because the HTML output has not yet started!!
ALL output should be in the BODY of the HTML page below.
Starting output early can break things like cookies.

2)
SELECT * FROM knuckles_animals WHERE animal_name='$animal'
MySQL queries are NOT case sensitive by default -- ANT will match ant
So this query is sufficient for this HW.

Extra mySQL Notes:

SELECT * FROM knuckles_animals WHERE animal_name LIKE '$animal'
This Query is NOT case sensitive either -- so it's basically the same as the above one

LIKE is good for substring searches,
Below will select any any animal_name that has $animal as a subsring
SELECT * FROM knuckles_animals WHERE animal_name LIKE '%$animal%'

Below will select any any animal_name that STARTS with $animal
SELECT * FROM knuckles_animals WHERE animal_name LIKE '$animal%'

See:
https://www.w3schools.com/sql/sql_like.asp
*/
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Basic Database Code</title>
  </head>
  <body>
    <span style="color:red"><?= $message ?></span>

    <br><br>
    Database table listing.
    <br><br>
    <?=$num_rows?> rows in database.
    <br><br>

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
          </tr>
        <? } // while ?>
      <? } // if ?>
    </table>

  </body>
</html>