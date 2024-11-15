<?
/*
This page should:
1) Display the signature in as indicated in the web page below.
2) Set a cookie (NOT PHP SESSION) that expires a year from now to record the timestamp when the survey was completed.
3) Display a human readable date/time when the survey was completed.
4) Display the time elapsed (broken down into minutes and seconds) since the cookie in the 1st page was set.
   This is effectively the time it took to complete the survey (including possibly going back from the 2nd page to re-edit it.)
5) Again display the survey data below.  You should be able to simply copy the same HTML/PHP from the 2nd page.
*/

/*
Note:
In a real setting, the survey data would be saved to DB at this point.
But this is an exercise in Cookies and PHP session management, so just display the data in this page.
*/
?>

<!DOCTYPE html>
<html>
  <head>
    <title>Thank You</title>
  </head>
  <body>
     Dear, (Put Signature Here)
     <br><br>
     Thank you for completing this survey, which is summarized further below.
     <br>
     Date Completed: (put here and use format like: January 15, 2022 at 4:30pm)
     <br>
     Time Elapsed Completing this Survey: (put here in minutes and seconds)
     <br><br>
     Should we find that you have perjured yourself, rest assured that our lawyers will contact you.

      <!-- Display Survey Data Here -->
  </body>
</html>