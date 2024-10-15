<?
// No blank line at beginning of script - would start script output.
// HTTP headers should be set before ANY script output begins.

header('Access-Control-Allow-Origin: *');                 // Allow Access from any origin
header('Content-Type: application/json; charset=UTF-8');  // JSON payload (not HTML)

// Another example will provide detailed discussion about HTTP header directives.


// API payload -- a PHP data structure encoded as a JSON string.

$arr = ["some","PHP","data","structure","parsed","into","JSON"];   // An array in this case
$json_string = json_encode($arr);
echo $json_string;
exit;

//  You can call this API from a Web browser just as you would any other PHP script

/*
NOTE:
An API should always return valid, parse-able JSON even if the response is empty (like a search with no results).

echo '[]';  // OK - empty JSON array    - same as echo json_encode([])
echo '{}';  // OK - empty JSON object   - same as echo json_encode(new stdClass())

echo json_encode('');  // OOPS - encoding an empty string gives "" which is NOT valid JSON

The first action of a calling API client is generally to parse the returned JSON.
Thus, returning Invalid JSON can cause an error in an API client.
*/

// Nothing after the closing PHP tag below, since no HTML output.
// Wouldn't be part of response anyway, since the exit exit terminates the script output above.
?>