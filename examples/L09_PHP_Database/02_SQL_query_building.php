<?
/*
Some help with strings in PHP and building SQL INSERT statements

There is no point in executing this script.
Just read the code and comments for some tasty tidbits of knowledge.
*/

// The auto-increment primary key is sent as NULL
// VARCHAR fields need to be quoted, but numeric fields (int, float, ...) do not

$query = "INSERT INTO table_name VALUES (NULL,'Ernie','Jones',33)";

// Simulating some incoming form data
$_GET['fname'] = 'Ernie';
$_GET['lname'] = 'Jones';

// Building a query by concatenating submitted form data is messy, since VARCHAR fields need quoted properly.

$query = "INSERT INTO table_name VALUES (NULL,'" . $_GET['fname']. "','" . $_GET['lname']. "',33)";

// PHP scalar variables (not arrays, or objects) are 'Interpolated' inside double quoted strings.

$x = "cats";

$y = "I love $x";  // will contain "I love cats"

$y = 'I love $x';  // will contain 'I love $x' if single quotes are used

// Associative array values can be Interpolated into double-quoted strings using {}.

$y = "I love {$_GET['fname']}";  // will contain 'I love Ernie'

// If the submitted data is stored in scalar variables, SQL queries are easily built using interpolation.

$fname = $_GET['fname'];
$lname = $_GET['lname'];

$query = "INSERT INTO table_name VALUES (NULL,'$fname','$lname',33)";

// Or by directly Interpolating associative array values, but that's more messy.

$query = "INSERT INTO table_name VALUES (NULL,'{$_GET['fname']}','{$_GET['lname']}',33)";

// YIKES - error - bad SQL syntax - hard to see when looking at the PHP that builds it
$query = "INSERT INTO table_name VALUES (NULL,'{$_GET['fname']},'{$_GET['lname']}',33)";

// $result = $mysqli->query($query);  // If you were to execute a bad SQL query
// var_dump($result);exit;            // PHP will only tell you false

/*
The solution is to var_dump() the raw queries themseleves.
var_dump($query);exit;
Maybe then you can better see the SQL error.

Better yet, paste the dumped raw SQL directly into the PHPMyAdmin GUI.
The "SQL" tab is near the "Browse" and "Structure" tabs.
The GUI will directly exectute the query and
  Show you the actual error mySQL is throwing
  OR
  Show you the query results (data returned) if there is no error

The bottom line is that within PHP it can be hard to find SQL errors or see exactly what queries return.
Pasting the raw queries into the GUI will show you exactly what is going on.

*/
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Query Construction in PHP</title>
  </head>

  <body>
    <br>
    The comments in the source code explain how to construct SQL queries in PHP and how to debug them.
  </body>
</html>