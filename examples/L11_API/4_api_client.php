<?
/*
Some Terminology:

An API (Aplication Programming Interface) allows one app to interact with another app through a programming interface.
An API might allow two apps to share raw binary data, plain text, or even function calls.

A REST API is a specific type of API that adheres to the "REpresentational State Transfer" model. See the Wiki for more info.
Think of a REST transaction as a stand-alone transfer of data representing current the state of a server resource (often database),
rather than some sort of continuing client/server interaction or conversation.

The term REST API is usually used in the context of a Web-based API where the REST part refers to how the API
is structured - called by a URL, HTTP(S) delivery, UTF-8 payloads (plain text), statelessness (no session state between client/server), etc.
A REST API is often called a "Web Service" (Web-based data service), or simply an API when the context is clear.

AJAX calls are a common way to call a REST API - basically a Web page grabs some data behind the scenes, then does something with it.
But any sort of App can call a REST API.

This script is an API client - basically a simple app that calls an API (previous example) to acquire some data.

NOTE: If you put the API in a differant location (student account, for example) change the URL below accordingly.
*/

$json_string = file_get_contents("https://csci.lakeforest.edu/knuckles/csci488/api/2_api_data.php?query=dog");

if ($json_string === false) {
  // file_get_contents() failed to get the API resource - URL not locating the API
  echo "Bad API Call";
  exit;
}

$arr = json_decode($json_string, true);

// true causes json_decode() to return an associative array.
// The default - json_decode($json_string) - would return a stdClass PHP object.

if ($arr === NULL) {
  // $json_string is ill-formed so wouldn't decode into a PHP data structure
  // If an API spits out bad JSON, there's not much you can do about it other then notify the API's owner to fix it.
  echo json_last_error_msg();
  exit;
}
?>

<!DOCTYPE html><html>
<head><title>API Client</title></head>
<body>

This API client simply puts some of the returned data into a Web page: <?=$arr['status_string']?>
<br><br>
In practice, the API data might be saved into a database and/or be used as part of a Web page
</body>
</html>

<?
/*
Notes regarding PHP's file_get_contents() function:

If you don't specify a protocol, file_get_contents() will default to reading the actual bytes from the file.
For example, if you use a relative URL like so
  file_get_contents("file.php");
it will simply return the file's contents as delivered by the local file system -- the PHP source code, not the API output.

Using a complete http URL to call the API causes the file to be delivered via the Web server, rather then the file system,
hence the PHP is executed.

It's interesting that file_get_contents() is quite versatile in that it can handle various protocols:
  file_get_contents("https://some_resource_url")          // whatever a web URL returns (API data or possibly just an HTML file)
                                                          // This is basically how bots/crawlers grab HTML files
  file_get_contents("ftp://some_resource_url")            // read bytes from a remote file
  file_get_contents("/local/file/system/path/to/file")    // read bytes from a local file


*/
?>
