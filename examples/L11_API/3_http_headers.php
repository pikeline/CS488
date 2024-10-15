<?
/*
HTTP Headers
  Meta Information sent as part of http(s) transactions.
  Not part of the actual transaction payload which is usually a web page or API data.
  IMPORTANT: Set HTTP headers BEFORE any script output.

header() - php function - adds a string to the HTTP headers

A couple headers are useful for APIs
*/

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');

/*
Access-Control-Allow-Origin: *
  Allows an API to be requested from any origin
Cross-Origin Resource Sharing (CORS)
  Browser default: A web page loaded from x.com can only make AJAX requests to an API at x.com
  Could set to specific origin:
    Access-Control-Allow-Origin: https://www.w3schools.com
  Can experiment by calling this API from the "Try it yourself" at https://www.w3schools.com/js/js_api_fetch.asp

Content-Type: application/json; charset=UTF-8
  Good pracice (but not required) when an API returns JSON data
    Calling agent (e.g. AJAX) knows what it's getting, perhaps automatically parsing JSON response string into an object.
  Without that, the default HTTP header tells calling agent to expect HTML data.
    Content-Type: text/html; charset=UTF-8
  The value of Content-Type is called a "MIME TYPE" (Multipurpose Internet Mail Extensions)
    Originally used to identify content of eMail attachments.
    https://developer.mozilla.org/en-US/docs/Web/HTTP/Basics_of_HTTP/MIME_types/Common_types
*/

header('My: String');

/*
header() php function merely adds a string to the HTTP headers.
In the above case, the calling agent would simply ignore an unrecognized HTTP header.
However, apps can invent their own custom HTTP headers for various purposes.
*/

setcookie("my_cookie_name", "Cookie Data");

/*
Some php functions such as setcookie() are wrappers that set a HTTP header behind the scenes!
*/

header('Content-Type: text/plain; charset=UTF-8');

/*
The text/plain MIME type declaration just above will override the application/json one set at the top.
The browser will honor the one that comes last (probably saves the value into an associative array with Content-Type key)
Notice that the text/plain will cause a browser to not even interpret the HTML <b></b> in the text below.
*/
?>

To see HTTP headers set by this page in the Chrome browser:
Chrome - Developer Tools -> Network

<b>AFTER</b> opening the Network pane, reload the API call, select the file, and then the Headers tab.
