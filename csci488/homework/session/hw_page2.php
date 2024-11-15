<?
/*
This page should:
1) Transfer to page 1 if:
   a) If the survey is completed and signed (like if hit back button on page 3). They will get a survey completed message on page 1.
   b) If the survey is not complete, but there is no survey data in session.  They will get a blank form on page 1.
      This can happen if someone sits on this page without submitting it and the session expires in the mean time.

2) Display the Survey Data submitted from the page 1.

3) The form in this page should submit to THIS PAGE.
    Use PHP to validate that the form below is completed.
      Validate that the signature is not the empty string or only blank spaces (use PHP trim() function)
      And of course validate that the checkbox was checked.
    If the validation passes, save the signature into SESSION and transfer to hw_page3.php.
    If the validation fails, don't transfer.
      Instead fall back through to the form in this page WITH an appropriate message.
      In that case, the Survey Data MUST also re-display in this page.

Note:
  hw_page1.php used client-side JavaScript validation to ensure that all data was collected.
  For the form below. do NOT use client-side JavaScript validation, but rather use PHP as instructed above.
  Clien-side validation is convenient for the end user, but can be bypassed by someone with know-how.
*/
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Verify Profile</title>
  </head>
  <body>

    <!-- Display Survey Data Here -->

    <br><br>
    <form action="" method="GET" >
      Verify that your profile data shown above is accurate by signing below.
      <br>
      <input type="text" name="signature" value="" placeholder="Sign Here">
      <br>
      <input type="checkbox" name="user_certify" value="yes">
      I certify, under penalty of purgery, that my profile is accurate.
      <br><br>
      <button type="button" onclick="window.location='hw_page1.php';"> Go Back: Edit Profile Before Signing </button>
      <!-- This is NOT a Submit Button! -->
      <br>
      <button type="submit"> Record Profile </button> &nbsp;&nbsp;
      <!-- This is obviously -->
    </form>

  </body>
</html>