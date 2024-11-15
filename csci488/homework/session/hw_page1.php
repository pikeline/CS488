<?
/*
This page should:

1) Use a cookie (NOT PHP SESSION) that expires a year from now to do the following:
Record the timestamp of the FIRST load of this page (but NOT any subsequent load of this page).

Note: You only need first 3 parameters in setcookie() for this HW.

2) If the suvey was already completed, instead of the survey form,
this page should display a message stating when the survey was completed.
A cookie you set in page 3 will allow you to detect this.


3) The form in this page should submit to THIS PAGE, and then transfer to hw_page2.php
after saving stuff to PHPs built-in $_SESSION superglobal.
The data will then be available in all the other pages (remember no database is allowed for this HW).

4) If the button in the 2nd page is clicked to come back to this page, the
Session data should re-populate into the form.

*/

?>

<!DOCTYPE html>
<html>
  <head>
    <title>User Profile</title>
  </head>
  <body>
     <h3><?=$message?></h3>

     User Profile:
     <br><br>
     <form action="" method="POST" name="form1" onsubmit="return validate_form()">
      <input type="hidden" name="task" value="process_profile">

       <input type="checkbox" name="is_cool" value="yes">
       Are you cool?
       <br><br>
       What Bands do you like?
       <br>
       <select name="like_bands[]" multiple>  <small>* Required Field</small>
          <option value="Sabbath">Black Sabbath</option>
          <option value="Mastodon">Mastodon</option>
          <option value="Metallica">Metallica</option>
         <option value="Swift">Taylor Swift</option>
       </select>
       <br><br>
       Favorite band not in the above list.
       <br>
       <input type="text" name="other_band" value="">
       <br><br>
       <button type="submit"> Continue/Confirm </button>
     </form>

     <script>
      //////////////////////////////////////////////////////////////////////////////////////////////////////////
      // Client-side form validation
      // Don't change the names of stuff in the form, and you won't have to change anything below
      // Used built-in JS instead of JQuery or other validation tool
      //////////////////////////////////////////////////////////////////////////////////////////////////////////
      function validate_form() {

        var form_obj = document.form1;

        var count_liked = 0;
        for (var i=0 ; i < form_obj['like_bands[]'].options.length ; i++ ) {
          if (form_obj['like_bands[]'].options[i].selected) {
            count_liked++;
          }
        }

        if (count_liked == 0) {
          alert("You must choose a band from the menu.");
          return false; // cancel form submission
        }

        return true;  // trigger form submission
      }
    </script>

  </body>
</html>