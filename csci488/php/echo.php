<?
// $_GET and $_POST are built-in PHP SuperGlobals that handle those kind of form submissions, respectively.
//The line below merges both into one array so that this script will handle both GET and POST form submissions.

$submitted_form_data = array_merge($_GET, $_POST);
?>
<!DOCTYPE html>
<html>

<head>
  <title>Echo of HTML Form Submission</title>
</head>

<body>
  This script echos back the data in all <tt>name=value</tt> pairs submitted by any HTML form.
  <hr>
  <br>

  <table width="" cellspacing="0" cellpadding="3">
    <tr>
      <th>Submitted Name</th>
      <td width="15">&nbsp;</td>
      <th>Submitted Value</th>
    </tr>

    <? foreach ($submitted_form_data as $key => $value) { ?>
      <tr>
        <td><?= $key ?></td>
        <td>&nbsp;</td>
        <td><?= $value ?></td>
      </tr>
    <? } ?>

  </table>
  The checkboxes that aren't submitted are the ones that are not checked. This is because there is no reason to send unchecked data to the server. It'll make a shorter query string.<br>
  When multiple items are selected, the server will receive an array of values. Although the script only displays the last value, the server will receive all of them.
  For example, favorite=fav_bear&favorite=fav_gorilla<br>
  Submitting with get shows the information in the address bar. Post hides this information in the body of the request.<br>

</body>

</html>