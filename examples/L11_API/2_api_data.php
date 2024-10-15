<?
// No blank line at beginning of script - would start script output.

header('Access-Control-Allow-Origin: *');                 // Allow Access from any origin
header('Content-Type: application/json; charset=UTF-8');  // JSON payload (not HTML)

/*
Call this API from a Web browser as follows (of course, you will need the full URL):
  file_name.php?query=data

Normally the data an API returns comes from a database or other data source.
But this example only returns some simple data, focussing instead on the logistics of an API call.
*/

$arr = [];   // Associative array to build data structure to be returned as JSON

if ( isset($_GET['query']) && strlen(trim($_GET['query'])) > 0 ) {
  $arr["status_code"]   = 1;
  $arr["status_string"] = $_GET['query'] . " was submitted.";
  $arr["some_data"]     = ["any","PHP","data","structure"];
}
else {
  $arr["status_code"]   = 0;      // Let the client know what went wrong
  $arr["status_string"] = "Invalid API Request: Invalid Query String";
  $arr["some_data"]     = [];     // empty array -- good practice if an array is expected
}

// Finally, the API payload -- the data structure encoded as a JSON string.

$json_string = json_encode($arr);
echo $json_string;
exit;

/*
Some important things to note:

**************************************************
A) Debugging Hints
***************************************************
var_dump($arr);
  Check the structure your PHP object (or associative array)

echo json_encode($obj , JSON_PRETTY_PRINT);
  Use a flag in the json_encode() function to better see the structure of the JSON string.
  DO NOT, leave JSON_PRETTY_PRINT on in the final production version of an API.
  Extra whitespace in JSON is not efficient in network transmission, and is generally considered bad practice for API output.

json_last_error_msg()
  Included with the PHP json_* functions.
  If your data structure won't parse into JSON,
  echo the value returned by this function AFTER json_encode() and you may get a hint of what's wrong.

**************************************************
B) Structure of the Data
**************************************************
Notice in the output of this API that the json_encode() of the PHP associate array results in a JSON object (not an array).

One could build API output using the generic PHP object class as shown below.
Below will create the EXACT same JSON as the Associative array used further above. Try it!

$obj = new stdClass();    // generic PHP object

$obj->status_code = 1;
$obj->status_string = $_GET['query'] . " was submitted.";
$obj->some_data  = ["a","PHP","data","structure"];

$json_string = json_encode($obj);

Neither way is necessarily preferable, but associative arrays are more flexible since the field names are strings.
$arr["field-name"] is legal since "field-name" is a string.
but
$obj->field-name is NOT legal since field-name is not a legal variable name.

Either way, it's good practice to use legal varaible names for data field names (whether DB fields, data structure fields, etc).

**************************************************
C) Cleaning Data
**************************************************
Sometimes you need to worry about nuances within your data source.
The PHP documentation for json_encode() defines several flags for dealing with various types of data.
For example, a default json_encode() might rusult in
["\u20ac","http:\/\/example.com\/some\/cool\/page","337"]

but
json_encode($array,  JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
would result in
["€","http://example.com/some/cool/page",337]

*/
?>