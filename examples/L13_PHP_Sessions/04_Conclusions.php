<?
session_start();  // Required in each page that uses built-in sessions
                  // MUST do this even if you only want to read previously stored session data
                  // PHP won't populate the $_SESSION superglobal without session_start()

/*
Propagating a Session
  PHP's default is that a session expires 24 minutes after the most recent transaction that executes session_start()
  Thus, it is usually best to call session_start() in the init.php file (or any file common to all scripts in the app).
  That way, the session will be propagated across the entire app since any page load will extend it by another 24 minutes.
*/

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Cookies and PHP Sessions Final Notes</title>
  </head>
  <body>
    <h3>Retrieving Data from Cookies and PHP Session</h3>

    This page accesses data that was saved by the pervious example scripts provided with this lesson.
    <br>
    <b>Therefore, you need to execute those scripts first in order for the cookie/session data they set to show up here.</b>

    <br><br>
    The <b>main purpose of cookies and sessions</b> is to share data across different transactions within the same Web app!
    <br><br>

    <table cellspacing="0" cellpadding="5">
      <tr>
        <td width="275"><b>Cookie/Session Variable</b></td>
        <td width="325"><b>Previously Saved Data</b></td>
        <td width="400"><b>Data Lifespan</b></td>
      </tr>
       <tr>
        <td><code>$_COOKIE["my_cookie_name"]</code></td>
        <td><?= $_COOKIE["my_cookie_name"] ?></td>
        <td>This cookie expires 24 hours after the script that sets it was last executed.</td>

      </tr>
      <tr>
        <td><code>$_SESSION['my_session_string']</code></td>
        <td><?= $_SESSION['my_session_string'] ?></td>
        <td rowspan="2">
          Sessions by default expire <?= ini_get('session.gc_maxlifetime')/60 ?> minutes after ANY script (including this one) executes <code>session_start()</code>.
          If you don't see saved session data to the left, you probably haven't executed the previous example or the session timed out.
        </td>
      </tr>
      <tr>
        <td><code>$_SESSION['my_session_array']</code></td>
        <td><?= json_encode($_SESSION['my_session_array']) ?></td>
      </tr>
    </table>

    <br>

    The above table should show some of the saved cookie/session data set by the other scripts <b>unless</b>:
    <ul>
    	<li>The Cookie or Session expired prior to loading this page.</li>
    	<li>You deleted the cookie or unset any of the session data in the other scripts.</li>
    	<li>You switch to a different Web browser and load this script (but not the other ones that set the data).</li>
    </ul>

    <b>Sessions vs Cookies</b>
    <ul>
    	<li>In general, either can be used in most cases to store data between transactions (e.g. shopping cart or maintaining logged-on state).</li>
    	<li>
    	  Sessions
    	  <ul>
    	    <li>Amount of data that can be stored is virtually unlimited.</li>
    	    <li>Only the PHPSESSID is viewable on the client.</li>
    	    <li>Easy to store and retrieve large amounts of data, even complex data structures.</li>
    	    <li>
    	      Automatically generates the session id (hashed value) and sets it in a cookie.
    	      <ul>
    	  	  	<li>But there is effectively only one session id per client.</li>
    	  	  </ul>
    	    </li>
    	  	<li>
    	  	  Automatically manage session lifetime and garbage collection of session data.
    	  	  <ul>
    	  	  	<li>But you have to be aware that default lifetime and gc_maxlifetime are relatively short and override them as necessary.</li>
    	  	  </ul>
    	  	</li>
    	  	<li>Has alternatives to setting the id in a cookie.</li>
    	  </ul>
    	</li>
    	<li>
    	  Cookies
    	  <ul>
    	    <li>Most browsers limit the data stored in a Cookie to 4KB.</li>
    	    <li>All of the data is viewable on the client.</li>
    	    <li>
    	      For lots of data, or complex data structures, it's usually saved to database with a unique identifier (usually a hashed value) set in a cookie.
    	      <ul>
    	        <li>
    	          You have to manually create the unique identifier.
    	        </li>
    	  	  	<li>
    	  	  	  You have to manually manage the database reads and writes. But MySQL provides more flexibility (search/sort) than php session read/write.
    	  	  	</li>
    	  	  	<li>You have to manually deal with garbage collection of session data.</li>
    	  	  </ul>
    	    </li>
    	  </ul>
    	</li>
    </ul>

  </body>
</html>