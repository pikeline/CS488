<?
/*
This example shows two different coding styles for dynamically generated HTML.

1) HTML with Embedded PHP control structures.

OR

2) HTML as String Output (echo or print) from the PHP script.

Many PHP scripts are actually some combination of the two coding styles.
Neither one is more "correct" than the other.
But professional Web programmers generally try to use style #1 regardless of language used: PHP, JSP, C#, etc.
*/

// Data Source for Dynamic HTML generation examples further below (could have come from a Database).
// This is an associative array of (keys => values)
$animal_data = [ 'wildebeest'=> 1,
                 'dog'=> 0,
                 'aardvark'=> 1,
                 'cat'=> 0,
                 'bandicoot'=> 1,
                 'bat'=> 0,
                 'muskox'=> 1,
                 'rat'=> 0
];
?>

<!DOCTYPE html>
<html>
<head>
  <title>PHP Coding Style Examples</title>
  <style>
  	 table, td, th {
         border-collapse: collapse;
         border: 1px solid black;
      }
  </style>

</head>
<body>

Below are two HTML structures built as raw HTML, with "embedded" PHP scripting.
<br>
This is generally how professional PHP programmers do it.
<hr>
<br>

<ul>
  <? foreach ($animal_data as $name => $is_cool) { ?>
    <li><?=$name?>
      <? if( $is_cool ) { ?>
        <ul>
        	<li type="square" style="color:red;font-size:.75em;">Qualifies as Cool Animal Name</li>
        </ul>
      <? } ?>
    </li>
  <? } ?>
</ul>

<table width="" cellspacing="0" cellpadding="3">
    <? foreach ($animal_data as $name => $has_pic) { ?>
        <tr>
          <td width="100"><?=$name?></td>
          <td>
            <? if( $has_pic ) { ?>
              <img src="animal_pics/<?=$name?>.png" height="50"/>
            <? } else { ?>
               Sorry, Not Picture Worthy
            <? } ?>
          </td>
        </tr>
    <? } ?>
</table>

<br>
Below are the EXACT same HTML structures, but as string output of PHP echo statements.
<br>
This is perhaps easier to understand for people new Web Programming, but is generally not how experienced programmers do it.
<hr>
<br>

<?
echo "<ul>";
foreach ($animal_data as $name => $is_cool) {
  echo "<li>$name";
  if( $is_cool ) {
    echo "<ul>
           <li type=\"square\" style=\"color:red;font-size:.75em;\">Qualifies as Cool Animal Name</li>
         </ul>";
  }
  echo "</li>";
}
echo "</ul>";
?>


<?
echo "<table cellspacing=\"0\" cellpadding=\"3\">";
foreach ($animal_data as $name => $has_pic) {
  echo "<tr>
          <td width=\"100\">$name</td>
          <td>";
  if( $has_pic ) {
    echo "<img src=\"animal_pics/$name.png\" height=\"50\"/>";
  }
  else {
     echo "Sorry, Not Picture Worthy";
  }
  echo "  </td>
        </tr>";
}
echo "</table>";
?>



</body>
</html>
