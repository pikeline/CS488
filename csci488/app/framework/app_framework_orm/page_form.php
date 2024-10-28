<?
require 'init.php'; // database connection, etc

// All the states from the database table in proper format to pass to  lib::menu_from_assoc_array()
$states = states::get_states_assoc_array();

$task = $get_post['task'];
switch ($task) {
    case 'save':
        // Save the form data then transfer to the listing page

        $ppl = new people();

        // Load the incoming form data into an ORM object
        // The names of the object's fields MUST match the names of the form elements
        $ppl->load_from_form_submit();

        // Framework will automatically addslashes() (escape reserved SQL chars),
        // so no need to manually do that here.

         // Some simple validation.
        if ( ! trim($ppl->values['ppl_name']) || !trim($ppl->values['ppl_age']) ) {
          $message = "You must provide a Name and Age";
          break; // fall back to form without saving
        }

        // Some of the data fields might need some pre-processing before being saved
        if ( is_array($ppl->values['ppl_states_visited']) ) {
          $ppl->values['ppl_states_visited'] = json_encode($ppl->values['ppl_states_visited']);
        }
        else {
          // No submitted values from menu - so store empty array
          $ppl->values['ppl_states_visited'] = json_encode(array());
        }

        // Save the contents of the object to the database.
        $ppl->save();
        header ("Location: page_listing.php");
        exit;
        break;

    ///////////////////////////////////////////////////////////////////
    case 'delete':

       if ( isset($get_post['ppl_id']) && $get_post['ppl_id'] > 0 ) {
          $ppl = new people();
          $ppl->delete($get_post['ppl_id']);
       }

       header ("Location: page_listing.php?deleted_message=yes");
       exit;
       break;

    ///////////////////////////////////////////////////////////////////
    case 'edit':
       // Edit an existing database record

       if ( ! isset($get_post['ppl_id']) ) {
          // No incoming ppl_id so just fall through to empty form
          break;
       }

       $ppl_id = $get_post['ppl_id'];

       $ppl = new people();
       $ppl->load($ppl_id);  // $ppl now an Active Record object for one database record.

       $chosen_states = json_decode($ppl->values['ppl_states_visited']);

       $ppl->html_safe();  // runs htmlentities() on all object fields
                           // to escape characters that are reserved in HTML
                           // Have to do this after json_decode() or will break the json

       break;

    ///////////////////////////////////////////////////////////////////
    default:
      // No incoming task gives empty form
}

// Common Page Top for all Application Pages
require 'ssi_top.php';
?>

This application template uses an Object Relational Mapping (ORM) framework.
<br>
You will notice that there is no SQL in any of the PHP files that generate HTML pages.
<br>
All the SQL is in the "data operations class" or the "table-specific classes" that extend the data operations class.

<br><br>
<a href="page_listing.php">Go To Listing Page</a>
<br><br>

<? if ($message) { ?>
  <div style="color:red;"><?=$message?></div><br>
<? } ?>

<!-- All the form element names (except task) match the DB table names  -->

<form name="form1" action="page_form.php" method="POST">
   <input type="hidden" name="task" value="save">
   <input type="hidden" name="ppl_id" value="<?= $ppl_id ?>">

   Name: <input type="text" name="ppl_name" value="<?= $ppl->values['ppl_name'] ?>">
   <br>
   Age: <input type="text" name="ppl_age" value="<?= $ppl->values['ppl_age'] ?>">
   <br><br>
    Select US states you have visited:
   <br>
   <?= lib::menu_from_assoc_array("ppl_states_visited[]", $states,'', $chosen_states, 'multiple'); ?>
   <br><br>
   <button type="submit"> Submit </button>
</form>


<?
// Common Page Top for all Application Pages
require 'ssi_bottom.php';
?>