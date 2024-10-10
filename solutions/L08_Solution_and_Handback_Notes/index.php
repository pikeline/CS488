<!DOCTYPE html>
<html>
	<head>
		<title>Lesson 8 Solution</title>
	</head>
	<body>
	   <form action="form_process.php" method="GET" >

	       <input type="text" name="name" value="" placeholder="Enter Your Name">
         <br>
         <input type="text" name="age" value="" placeholder="Enter Your Age">
         <br>
         <input type="checkbox" name="i_rock" value="1"> I like to Rock.
         <br>
         Select Bands You Like
         <select name="bands[]" multiple>
         	  <option value="Mastodon">Mastodon</option>
         	  <option value="Metallica">Metallica</option>
         	  <option value="Sabbath">Black Sabbath</option>
         	  <option value="Sabbath">Taylor Swift</option>
         </select>
         <br><br>
	       <button type="submit"> Submit </button>
	       <!-- Don't name form buttons or you will a name=value pair will be submitted.  -->
	   </form>

	</body>
</html>