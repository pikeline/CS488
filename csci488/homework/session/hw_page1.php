<?
session_start();

$now = time();
if(!isset($_COOKIE["c_first_load"])){
  setcookie("c_first_load", $now, $now + 60*60*24*365);
}

if($_POST["task"] == "process_profile"){
  $_SESSION["is_cool"] = $_POST["is_cool"] == "yes" ? "yes" : "no :(";
  $_SESSION["like_bands"] = $_POST["like_bands"];
  $_SESSION["other_bands"] = $_POST["other_band"];

  header("Location: hw_page2.php");
}

$is_completed = isset($_COOKIE["c_completed"]);
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
function in_session($session_name, $name = ""){//wrapper to search session
  if (!isset($_SESSION[$session_name])){//check for session existence
    return false;
  }
  if ($session_name == "like_bands"){
    return in_array($name, $_SESSION["like_bands"]);
  }
  if($session_name == "is_cool"){
    return $_SESSION[$session_name] == "yes";
  }
  echo "error - invalid parameter or something";
  return false;
}
?>

<!DOCTYPE html>
<html>
  <head>
    <title>User Profile</title>
  </head>
  <body>
    <div style="visibility:<?= $is_completed ? "" : "hidden"?>">
      This survey was completed at <?= date("F d\, o \a\\t h:ia", $_COOKIE["c_completed"]);?>
    </div>

    <div style="visibility:<?= $is_completed ? "hidden" : ""?>">
     User Profile:
     <br><br>
     <form action="" method="POST" name="form1" onsubmit="return validate_form()">
      <input type="hidden" name="task" value="process_profile">

       <input type="checkbox" name="is_cool" value="yes" <?= in_session("is_cool") ? "checked" : ""?>>
       Are you cool?
       <br><br>
       What Bands do you like?
       <br>
       <select name="like_bands[]" multiple>  <small>* Required Field</small>
          <option value="Sabbath" <?= in_session("like_bands", "Sabbath") ? "selected" : ""?>>Black Sabbath</option>
          <option value="Mastodon" <?= in_session("like_bands", "Mastodon") ? "selected" : ""?>>Mastodon</option>
          <option value="Metallica" <?= in_session("like_bands", "Metallica") ? "selected" : ""?>>Metallica</option>
         <option value="Swift" <?= in_session("like_bands", "Swift") ? "selected" : ""?>>Taylor Swift</option>
       </select>
       <br><br>
       Favorite band not in the above list.
       <br>
       <input type="text" name="other_band" value="<?= htmlspecialchars($_SESSION["other_bands"])?>">
       <br><br>
       <button type="submit"> Continue/Confirm </button>
     </form>
    </div>

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