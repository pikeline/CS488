<?
require 'init.php'; // database connection, etc

$task = $get_post['task'];
switch ($task)  {

    case 'save':
        // Create a database record From Form Submission

        if ( isset($get_post['crud_id']) && $get_post['crud_id'] > 0 ) {
          $crud_id = $get_post['crud_id'];  // need to update existing person DB record
        }
        else {
          $crud_id = 0;                    // need to create new person DB record
        }

        // addslashes() escapes characters like ' and " in the data that can break SQL statements
        // and also leave a database vulnerable to SQL Injection attacks.
        // remove addslashes() and submit data containing a ' and see what happens.
        $crud_name      = addslashes(trim($get_post['crud_name']));
        $crud_age       = addslashes(trim($get_post['crud_age']));
        $crud_is_cool   = addslashes(trim($get_post['crud_is_cool']));  // empty string if checkbox isn't checked

        // Server-Side Validation
        if ( !$crud_name || !$crud_age ) {
          // reload this page with error message
          // Ideally, client-side form validation would have caught this

          if ( $crud_id > 0 ) {
            $transfer_url = "page_form.php?incomplete=yes&task=edit&crud_id=$crud_id";
          }
          else {
            $transfer_url = "page_form.php?incomplete=yes";
          }
          header ("Location: $transfer_url");
          exit;
        }

        if ( $crud_id > 0 ) {
          // Build the UPDATE statement
          $sql = "UPDATE " . CRUD_EXAMPLE_TABLE . " SET crud_name    ='$crud_name',
                                                        crud_age     = $crud_age,
                                                        crud_is_cool = '$crud_is_cool'
                                                    WHERE crud_id=$crud_id ";
        }
        else {
          // Build the INSERT statement
          $sql = "INSERT INTO " . CRUD_EXAMPLE_TABLE . " VALUES (NULL,'$crud_name','$crud_age','$crud_is_cool')";
        }

        // Execute the SQL query
        lib::db_query($sql);

        // Transfer to the listing page -- not good to leave the browser sitting on a post data transaction
        // The PHP header function adds the Location directive to the HTTP response header, which then causes the browser to do the transfer.
        header ("Location: page_listing.php");
        exit;
        break;
        /////////////////////////////
        // End Save Case
        /////////////////////////////

    case 'delete':
      // Just delete that puppy

       if ( isset($get_post['crud_id']) && $get_post['crud_id'] > 0 ) {
          $crud_id = $get_post['crud_id'];
       }

       // Build the DELETE statement
       $sql = "DELETE FROM " . CRUD_EXAMPLE_TABLE . " WHERE crud_id=$crud_id ";
       lib::db_query($sql);

       header ("Location: page_listing.php?deleted_message=yes");
       exit;
       break;

      /////////////////////////////
      // End delete Case
      /////////////////////////////

    case 'edit':

      if ( ! isset($get_post['crud_id']) || $get_post['crud_id'] <= 0 ) {
        // if no incoming crud_id, just give blank form
        break;
      }

      $crud_id = $get_post['crud_id'];
      $sql = "SELECT * FROM " . CRUD_EXAMPLE_TABLE . " WHERE  crud_id=$crud_id ";
      $result = lib::db_query($sql);
      $row = $result->fetch_assoc();  // will only be one row

      /*
        Certain characters like " and < and > are reserved in HTML,
        so will break the HTML if present in the data. The htmlspecialchars()function
        converts them all into HTML character entities &quot; and &lt; and &gt;
      */
      $crud_name = htmlspecialchars($row['crud_name']);
      $crud_age  = htmlspecialchars($row['crud_age']);

      /*
        It would be tempting to allpy htmlspecialchars() to every column from the DB like below

        foreach ($row as $key => $value) {
          $row[$key] = htmlspecialchars($value);
        }

        But if a column contains serialized data, htmlspecialchars() can mess that up.
        Plus, the radio/checkbox/menu values are not user entered, so shouldn't need cleaned up anyway.
      */

      break;

      /////////////////////////////
      // End edit Case
      /////////////////////////////

    default:
    // switch default case (no task submitted)
    // just drops into the page with blank HTML form
}

?>

<!DOCTYPE html>
<html>
  <head>
    <title>PHP/MySQL CRUD Example</title>
  </head>
  <body>
     <? if( $get_post['incomplete'] ) { ?>
        Your Form Submission was Missing Data
        <br><br>
     <? } ?>

     <br>

     <a href="page_listing.php">Go To CRUD Listing Page</a> or create a new Database Record below.

     <br><br>

     <!-- This Form Submits to THIS file!  -->
     <form action="page_form.php" method="POST" >
         <input type="hidden" name="task" value="save">
         <input type="hidden" name="crud_id" value="<?=$crud_id?>">

         Name: <input type="text" name="crud_name" value="<?= $crud_name ?>">
         <br>
         Age: <input type="text" name="crud_age" value="<?= $crud_age ?>">
         <br>
         <input type="checkbox" name="crud_is_cool" value="yes" <? if($row['crud_is_cool'] == 'yes'){echo 'checked="yes"';} ?> >
         This person is cool.
         <br><br>
         <button type="submit"> Submit </button>
     </form>

  </body>
</html>