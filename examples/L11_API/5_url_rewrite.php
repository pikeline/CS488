<?
/*
This API client demonstrates what a "URL Rewrite" is.

This client calls the following URL

https://csci.lakeforest.edu/~knuckles/csci488/api/cat

which is transformed into the following URL to call an API example from this lesson.

https://csci.lakeforest.edu/~knuckles/csci488/api/2_api_data.php?query=cat

The actual URL rewrite is done by the .htaccess file in the api folder.  It's a hidden file (starts with .)
That file contains an explanation of how the URL Rewrite works.

URL rewrites are often used for APIs to simplify the URL used to call the API.
They are also used by many other types of web apps, like shopping sites.
It's much more human friendly to see something like

www.buystuff.com/shoes/running

instead of the actual url that passes the data into the server side script

www.buystuff.com/script.php?category=shoes&type=running

Try either URL below (in this client or directly in the browser's address field) and you get the same result.

https://csci.lakeforest.edu/~knuckles/csci488/api/cat
https://csci.lakeforest.edu/~knuckles/csci488/api/2_api_data.php?query=cat
*/

$json_string = file_get_contents("https://csci.lakeforest.edu/~knuckles/csci488/api/cat");
$api_response = json_decode($json_string,true);
?>

<!DOCTYPE html><html>
<head><title>API Client Showing URL Rewrite</title></head>
<body>
<?=$api_response['status_string']?>
</body>
</html>
