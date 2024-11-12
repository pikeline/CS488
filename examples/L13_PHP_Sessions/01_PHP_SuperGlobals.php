<!DOCTYPE html>
<html>
<head>
<title>PHP Super Globals</title>
<style>code {font-weight:bold;font-size:1.25em;}</style>
</head>
<body>
<code>PHP SuperGlobals</code> are Associative Arrays that are built into PHP.
They are called SuperGlobal since they have complete global scope - can be accessed in ANY scope (inside functions, etc.)
<br>
You are likely already quite familiar with <code>$_GET</code> and <code>$_POST</code>, which receive incoming query string data.
<br>
There are a few other important ones.
<br><br>
<code>$_SERVER</code> Environment Variables <small> See source code view in Chrome to see all the keys and values in the <code>var_dump($_SERVER)</code> below.</small>
<br><br>
<?=var_dump($_SERVER);?>

<br><br>
Some useful ones:
<br><br>

<table cellspacing="0" cellpadding="5">
 <tr>
   <td><code>$_SERVER['REMOTE_ADDR']</code></td>
   <td>Client IP address</td>
   <td><?= $_SERVER['REMOTE_ADDR'] ?></td>
 </tr>
 <tr>
   <td><code>$_SERVER['PHP_SELF']</code></td>
   <td>This Script (according to Apache Web Server)<br><small>Useful as value of action="" in HTML form to always subits to same script.</small></td>
   <td><?= $_SERVER['PHP_SELF'] ?></td>
 </tr>
 <tr>
   <td><code>$_SERVER['HTTPS']</code></td>
   <td>Secure Transaction?<br><small>If not "on" can transfer to https URL. (Or do with Mod Rewrite in .httpaccess file.)</small></td>
   <td><?= $_SERVER['HTTPS'] ?></td>
 </tr>
 <tr>
   <td><code>$_SERVER['REQUEST_TIME']</code></td>
   <td>Timestamp (when this script started executing)</td>
   <td><?= $_SERVER['REQUEST_TIME'] ?></td>
 </tr>
</table>
<br>
Note: Timestamp is standard Unix-style format (from POSIX), also known as Epoch time.
The "Epoch" began at January 1, 1970 00:00:00 (UTC) - essentially an arbitrary time marking the beginning of the modern computer era.
The timestamps are literally the exact number of seconds since the Epoch began.
<br><br>
Here is the output of the PHP <code>time()</code> function: <?=time()?>
<br>
Will generally be the same as <?= $_SERVER['REQUEST_TIME'] ?> for a quick script.

<?
sleep(1);  // 1 second script execution delay
?>
<br><br>
Here is the output of the PHP <code>time()</code> function AFTER a one second script pause (sleep(1)) : <?=time()?>
<br>
Sometimes PHP scripts don't execute quickly, perhaps waiting for API results or a slow database query.
<br><br>

</body>
</html>


