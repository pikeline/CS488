<?
$submitted_form_data = array_merge($_GET,$_POST);

/*
  The order of the HTML form elements determines the order of the name=value pairs in the query string.
  That determines the order of the key=>value pairs in the $submitted_form_data associative array.
  Thus, looping over the $submitted_form_data as in the echo.php program, ALWAYS echos the
  the form data in the exact same order as the form elements are defined in the HTML.

  In general, changing the order of stuff in an HTML form shouldn't
  directly affect how a server-side script processes or presents the the data.

  The easiest way to do this is just to build the table manually like below.
  The order of the columns is completely independent of the order of the form.
  Certain type of form data, like multiple selects and checkboxes, might need some additional work as shown below.
*/

?>

<!DOCTYPE html>
<html>
<head>
  <title>Echo of HTML Form Submission</title>
   <style>
  	 table, td, th {
         border-collapse: collapse;
         border: 1px solid black;
      }
  </style>
</head>
<body>

<br>

<table width="" cellspacing="0" cellpadding="3">
   <tr>
     <th>Submitted Name</th>
     <th>Fave Bands</th>
     <th>Person Likes to Rock</th>
     <th>Submitted Age</th>
   </tr>
   <tr>
     <td><?= $submitted_form_data['name'] ?></td>
     <td><?= implode('<br>',$submitted_form_data['bands']) ?></td>
     <td><?= $submitted_form_data['i_rock'] ? 'Yes' : 'No: Submitter is Lame' ?></td>
     <td><?= $submitted_form_data['age'] ?></td>
   </tr>
</table>

</body>
</html>
