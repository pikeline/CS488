<?
/*
Cookie - Originally called a "Magic Cookie"
  Server-side script tells the Web browser to save a cookie (small amount of data)
  Web browser returns the cookie in subsequent transactions, but ONLY to the same domain that set the cookie.
  Different Web browsers don't "share" cookies. For example, Chrome doesn't know about a cookie set on Safari.
  However, a cookie is shared among all tabs/windows of SAME browser.
*/

// Set a Cookie:
// Expiration lifespan can be set up to a year - browser automatically deletes expired cookies
$expires_timestamp = time() + 60*60*24 * 1;       // (seconds per day)x(1 day) (better than typing a huge number of seconds)

$human_friendly_ts = date("Y-m-d H:i:s", $expires_timestamp);  // MySQL DATETIME format - Sortable!

setcookie("my_cookie_name", "Cookie Data (set by this script) Expires: $human_friendly_ts", $expires_timestamp);

// IMPORTANT: Cookies are sent to the client in the HTTP(s) response header. (Requesting Browser reads on the client-side.)
//            Therefore,  setcookie() should be called BEFORE any HTML output begins.

// To Delete a Cookie - Set Cookie with same name, but expiration in past.
// setcookie("my_cookie_name", "", time() - (60*60)); // one hour ago
// This tells the Web Browser to delete it

// Returned Cookies:
// PHP automatically populates the $_COOKIE SuperGlobal with ALL cookies returned in HTTP header
$returned_cookie_value = $_COOKIE["my_cookie_name"];

?>
<!DOCTYPE html>
<html>
<head>
<title>Cookies</title>
<style>code {font-weight:bold;font-size:1.25em;}</style>
</head>
<body>
<code>$_COOKIE</code> SuperGlobal contains all Incoming Cookies (returned by the web browser).
<br>
<small>See source code view in Chrome to see all the keys and values in the <code>var_dump($_COOKIE)</code> below.</small>
<br><br>
<?=var_dump($_COOKIE);?>
<br><br>
This script sets one cookie named <b>my_cookie_name</b>. Here is the retuned value: <b><?=$returned_cookie_value?></b>
<br><br>

Notes:
<ul>
 <li>The very first time a browser loads this script, it sets <b>my_cookie_name</b>. So the Returned Cookie Value is initially empty.</li>
 <li>Reload this page and the browser will return the cookie set in the previous transaction.</li>
 <li>Each transaction resets the expiration timestamp.</li>
</ul>

<b>Read the source code for further explanation about Cookies.</b>
<br><br>

To see incoming cookies:
<ul>
 <li>Chrome -> Developer Tools -> Application (click on the Web site) -> Cookies</li>
 <li>Interesting (or scary) observation:
    <ul>
     <li>Go to a major commercial site like ESPN or whatever.</li>
     <li>First, look at the incoming cookie values (Dev Tools -> Application -> Cookies)</li>
     <li>Then, look at the resource requests that are setting them (Dev Tools -> All -> Cookies)</li>
     <li>Yikes! (We'll talk about Web Beacons at somepoint.)</li>
   </ul>
 </li>
</ul>

To see the Cookies in the actual HTTP headers:
<ul>
 <li>Chrome -> Developer Tools -> Network</li>
 <li>Then reload the page you are on.</li>
 <li>Then click on a loaded resourse (html file, js file, image, etc) to see the HTTP response headers.</li>
 <li>Request Header (contains returned cookies)<br>Response Header (sets cookies)</li>
</ul>

</body>
</html>
<!--
Additional Information:

Cookie Domains
  By default, cookies are FQDN-specific. csci.lakeforest.edu is an example of a FQDN (Fully Qualified Domain Name)
    For example, a cookie set by csci.lakeforest.edu will NOT be sent to a request from math.lakeforest.edu.
  User accounts are treated like different domains.
    For example, a cookie set by csci.lakeforest.edu/~user1 will NOT be sent to a request fromcsci.lakeforest.edu/~user2

Cookie Paths
  A specific "Path" can be set using one of the optional parameters of setcookie()
  If the path is set to /app1, then cookies remain unique to that folder AND subfolders.
    That is, a cookie set by a script in csci.lakeforest.edu/app1 will NOT be sent to csci.lakeforest.edu/app2
  This keeps cookies from different apps on the same server from getting mixed up.

Persistent Cookie vs Session Cookie
  Persistent Cookies, such as set in the code above, have an explicit expiration time.
  If a cookie is set with no expiration time, it's called a Session Cookie.
  setcookie("my_session_cookie", "Session Cookie Data");
  A browser automatically deletes session cookies when the browser app is quit (ending the browsing session).
  Most people use Persistent Cookies these days since you have more control over the lifespan.
  Session Cookies were used more often before browser tabs were invented.
  Now people keep browsers open indefinitely and close/open tabs when needed.

Cookie Limits
  Different Browsers have different limits, so it's best to use the Lowest Common Denominator - something like:
  Max of 50 set per domain (relatively big number - not really a limiting factor)
  4K of data per domain (per cookie in some browsers)
    That's a relatively small amount of cookie data, but again not really a limiting factor
    since cookies are mostly used to store unique identifiers that Web apps use to identify individual clients.

Retuned cookies can also be obtained from the $_REQUEST superglobal - $_REQUEST["my_cookie_name"]
  I tend to avoid using $_REQUEST since it also contains $_GET[] and $_POST[] data.
  Essentially:  $_REQUEST = array_merge($_COOKIE, $_GET, $_POST)
  Can cause problems if the name of a cookie matches the name of an HTML form element.
-->