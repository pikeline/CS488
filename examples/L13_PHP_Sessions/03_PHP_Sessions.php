<?
session_start();  // Required in each page that uses built-in PHP sessions
                  // Enables Web programmers to store data between transactions without having to manually database it

/*
session_start() AUTOMATICALLY causes a lot of stuff to happen:

1) Sets a cookie named PHPSESSID containing a long random identifier like: lphu1jmi7amj8eckr9m233tpba
2) Creates a file named with that identifier.  On an Ubuntu Linux server it would be:
   /var/lib/php/sessions/sess_lphu1jmi7amj8eckr9m233tpba
3) Any data assigned to the $_SESSION superglobal is stored in that file.
   $_SESSION['my_session_key'] = "My Session Data";
4) On a subsequent transaction, a returned PHPSESSID cookie causes PHP to locate the appropriate sesson file
    and load any saved session data back into the $_SESSION superglobal for any use you choose.
    echo $_SESSION['my_session_key']

Additional Notes:
- Since browsers don't share cookies, a PHPSESSID identifies each Web browser uniquely.
- Sessions expire after a period of time.
- PHP automatically "garbage collects" expired PHP session files so they don't accumulate.

You can configure session_start() by sending an associative array of config values:
Below are some examples - values show the default Settings.

session_start([
    'gc_maxlifetime' => 1440,       // Garbage Collect Lifetime - 1440 seconds is 24 minutes)
                                    // Apache can wipe session file any time after this.
    'cookie_lifetime' => 0,         // Session Cookie Lifetime - 0 seconds means Session Cookie (see previous example)
                                                               - For persistent cookie, set non-zero value (smaller than gc_maxlifetime)
                                    // Session cookies can live longer than garbage collect gc_maxlifetime - cookie returned, but data gone
    'cookie_secure' => 0,           // Does not require https transaction - works with http
    'cookie_httponly' => 1          // Not sent for other protocols, like JavaScript ws:// or wss://  (web socket transactions)
    'use_only_cookies' => 1,        // Prevents session IDs from being set in URLs if cookies are not enabled
]);
*/

// unset($_SESSION['some_key']); // Remove only the some_key session variable
// session_unset();              // Unset every $_SESSION key
// session_destroy();            // Destroy entire session - deletes the PHPSESSID cookie


// It's easy to retrieve SESSION config values using ini_get() function (get initialization values).
$session_length_seconds = ini_get('session.gc_maxlifetime');
$session_length_minutes = $session_length_seconds/60;

$_SESSION['my_session_string']  = "Session Data";
$_SESSION['my_session_lifespan'] = $session_length_minutes;

// You can save whole structures (arrays, objects, etc) into session variables.
$a = ['dog','cat','rat'];
$_SESSION['my_session_array'] = $a;

$animals = ['dog'=>'Poodle','cat'=>'Siamese'];
$_SESSION['my_session_assoc'] = $animals;
?>
<!DOCTYPE html>
<html>
  <head>
    <title>PHP Sessions 1</title>
  </head>
  <body>
     <h3>Saving Data in a PHP Session</h3>

     This script stores various data types into PHP Session variables.
     <br>
     The saved session data is available in the same script in which it is saved.
     <br>
     It's also available in other scripts, subject to the <b><?= $_SESSION['my_session_lifespan'] ?> minute session lifespan</b>.
     <br><br>

     <table cellspacing="0" cellpadding="5">
         <tr>
           <td width="250"><b>Session Variable</b></td>
           <td><b>Saved Value</b></td>
         </tr>
         <tr>
           <td><code>$_SESSION['my_session_string']</code></td>
           <td><?= $_SESSION['my_session_string'] ?></td>
         </tr>
         <tr>
           <td><code>$_SESSION['my_session_array']</code></td>
           <td><?= implode(', ', $_SESSION['my_session_array']) ?></td>
         </tr>
     </table>
     <br><br>
     Read the source code for further explanation about PHP Sessions.
     <br><br>

     When using sessions, PHP automatically creates the <code>PHPSESSID</code> and sets it in a cookie.
     <br>
     When coding PHP, you don't even need to see it.  But the browser does store it as a normal cookie.
     <br>
     To save you the trouble of finding it in your browser's developer's tools in case you are curious:
     <br>
     Current <code>PHPSESSID</code>: <code><?= $_COOKIE["PHPSESSID"] ?></code>


  </body>
</html>
