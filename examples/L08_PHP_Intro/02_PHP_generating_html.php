<?
/* 
This server-side PHP script dynamically generates an HTML list from a PHP data structure. 
The data is hardcoded as a PHP array of strings.
In a real setting, the data would likey come from querying a relational database.
Most Web content is dynamically generated by server-side scripts (PHP, or other) from server-side databases.
*/

$cool_animal_names = array('wildebeest','aardvark','bandicoot','muskox','pangolin','dik-dik','pudu','wallaby');


?>
<!DOCTYPE html>
<html>
<head>
   <meta charset="UTF-8">
   <title>Generating HTML from PHP</title>
</head>
<body>
 This list is dynamically generated from a server-side PHP array. 
 <br />
 First look at the source code in the PHP file to see how it works.
 <br />
 Then look at the HTML code this script sends to the browser (view source) and the PHP will be gone!
 <br />
 
 <ul>
  <? foreach ($cool_animal_names as $name) { ?>
       <li><?=$name?></li>
  <? } ?>
 </ul>

</body>
</html>
