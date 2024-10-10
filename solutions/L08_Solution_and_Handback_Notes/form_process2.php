<?
$submitted_form_data = array_merge($_GET,$_POST);

/*
  This solution is not as simple as the first one. But it is more versatile.
  Notice the following in particular:
    All processing of the data is handled before the HTML output begins.
    If more form elements were added, or their order changed, the HTML code would NOT need to be altered.

  That type of division of labor is somethimes desirable.
    The programmer can change the application/data logic without changing the HTML.
    The front end designer has some pretty simple HTML to deal with, and doesn't see the application logic.
*/

/*
  Below, I create an Associative Array to associate form element names with human readable column headers.
  Looping over this array is completely independent of the order of the form in the HTML.
*/

$column_headers = array(
  'name'    => 'Submitted Name',
  'bands'   => 'Fave Bands',
  'i_rock'  => 'Submitter Likes to Rock',
  'age'     => 'Submitted Age'
);

// grab the keys (form element names)  -- easy to loop over
$form_element_names = array_keys($column_headers);

// to store the values for each column
$column_values = [];

foreach ($form_element_names as $name) {
  $data = $submitted_form_data[$name];

  // Process the data for display, depending upon what type of data it is.
  if( is_array($data) ) {
    $column_values[$name] = implode('<br>',$data);
  }
  else if ($name == 'i_rock') {
    $column_values[$name] = $data ? 'Yes' : 'No: Submitter is Lame';
  }
  else {
    $column_values[$name] = $data;  // just the raw data for text fields, etc
  }
}

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
    <? foreach ($form_element_names as $name) { ?>
        <th><?= $column_headers[$name] ?></th>
    <? } ?>
  </tr>
  <tr>
    <? foreach ($form_element_names as $name) { ?>
        <td><?= $column_values[$name] ?></td>
    <? } ?>
  </tr>
</table>

</body>
</html>
