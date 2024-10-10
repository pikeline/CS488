<?
require 'init.php'; // database connection, etc

// Selects all fields and all records from the table
$sql = "SELECT * FROM " . CRUD_EXAMPLE_TABLE . " WHERE 1 ORDER BY crud_name ASC ";
$result = lib::db_query($sql);

$num_rows = $result->num_rows;
?>

<!DOCTYPE html>
<html>
    <head>
      <title>Non-Fancy Listing of People Table</title>
      <script type="text/javascript">

      function confirm_delete(crud_id, crud_name) {
        var choice = confirm("Are you sure you want to delete " + crud_name + "?");

        if ( choice == true ) {
          window.location.href = "page_form.php?task=delete&crud_id="+crud_id;
        }
      }
    </script>

    </head>
    <body>
       <a href="page_form.php">Go to the data form. </a>
       <br><br>

       <? if ( isset($get_post['deleted_message']) ) { ?>
          <b>The DB record was sucessfuly deleted.</b>
          <br><br>
      <? } ?>

       <? if ($num_rows == 0) { ?>
          <b>No records were found in the database.</b>
       <? } else { ?>

        <b>Listing of Database Records:</b>

        <table width="" border="1" cellspacing="0" cellpadding="5">
          <tr  valign="top">
            <td>Name</td>
            <td>Age</td>
            <td>Person is Cool</td>
            <td>&nbsp;</td>
         </tr>
         <? while ( $row = $result->fetch_assoc() ) { ?>
            <tr  valign="top">
               <td><?= $row['crud_name'] ?></td>
               <td><?= $row['crud_age'] ?></td>
               <td><?= $row['crud_is_cool'] ? 'Yes' : 'No' ?></td>
               <td>
                  <a href="page_form.php?task=edit&crud_id=<?=$row['crud_id']?>">Edit</a>
                  &nbsp;&nbsp;|&nbsp;&nbsp;
                  <a href="#null" onclick="confirm_delete(<?=$row['crud_id']?> , '<?=$row['crud_name']?>')">Delete</a>
               </td>
            </tr>
          <? } // end while ?>
        </table>

      <? } // end else ?>

    </body>
</html>