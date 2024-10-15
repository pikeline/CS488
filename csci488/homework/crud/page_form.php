<?
require 'init.php'; // database connection, etc

$task = $get_post['task'];
$sChecked = 'checked';
$confidence_options = array(
    "1" => "Yes",
    "0" => "No"
);
$favorite_options = array(
    "bear" => "Bear",
    "gorilla" => "Gorilla",
    "human" => "Human"
);
// Arena select associative array
$arena_options = array(
    "urban" => "Urban",
    "suburban" => "Suburban",
    "rural" => "Rural"
);

switch ($task) {

    case 'save':
        // Create a database record From Form Submission

        if (isset($get_post['id']) && $get_post['id'] > 0) {
            $id = $get_post['id'];  // need to update existing person DB record
        } else {
            $id = 0;                    // need to create new person DB record with auto increment
        }

        // addslashes() escapes characters like ' and " in the data that can break SQL statements
        // and also leave a database vulnerable to SQL Injection attacks.
        // remove addslashes() and submit data containing a ' and see what happens.
        $name = addslashes(trim($get_post['name']));
        $email = addslashes(trim($get_post['email']));
        $age = $get_post['age'];
        $winner = addslashes(trim(json_encode($get_post['winner'])));  // empty string if checkbox isn't checked
        $scariness = addslashes(trim($get_post['scariness']));
        $arena = addslashes(trim($get_post['arena']));
        $favorite = addslashes(trim(json_encode($get_post['favorite'])));
        $factor = addslashes(trim($get_post['factor']));
        $confidence = trim($get_post['confidence']);
        $explanation = addslashes(trim($get_post['explanation']));

        // Server-Side Validation
        if (!$name || !$age || !$email || !$winner || !$scariness || !$arena || !$favorite || !$factor || !$explanation) {
            // reload this page with error message
            // Ideally, client-side form validation would have caught this
            $incomplete = "Yes";
            if ($id > 0) {
                $transfer_url = "page_form.php?incomplete=$incomplete&task=edit&id=$id";
            } else {
                $transfer_url = "page_form.php?incomplete=$incomplete";
            }
            header("Location: $transfer_url.");
            exit;
        }

        if ($id > 0) {
            // Build the UPDATE statement
            $sql = "UPDATE " . BATTLE_TABLE . "name='$name', email='$email', age='$age', winner='$winner', scariness='$scariness, arena='$arena', favorite='$favorite', factor='$factor', confidence='$confidence', explanation='$explanation', hidden='$hidden' WHERE id=$id ";
        } else {
            // Build the INSERT statement
            $sql = "INSERT INTO " . BATTLE_TABLE . " VALUES (NULL, '$name', '$email', $age, '$winner', '$scariness', '$arena', '$favorite', '$factor', '$confidence', '$explanation', '$hidden')";
        }

        // Execute the SQL query
        lib::db_query($sql);

        // Transfer to the listing page -- not good to leave the browser sitting on a post data transaction
        // The PHP header function adds the Location directive to the HTTP response header, which then causes the browser to do the transfer.
        header("Location: page_listing.php");
        exit;
    /////////////////////////////
    // End Save Case
    /////////////////////////////

    case 'delete':
        // Just delete that puppy

        if (isset($get_post['id']) && $get_post['id'] > 0) {
            $id = $get_post['id'];
        }

        // Build the DELETE statement
        $sql = "DELETE FROM " . BATTLE_TABLE . " WHERE id=$id ";
        lib::db_query($sql);

        header("Location: page_listing.php?deleted_message=yes");
        exit;

    /////////////////////////////
    // End delete Case
    /////////////////////////////

    case 'edit':

        if (!isset($get_post['id']) || $get_post['id'] <= 0) {
            //give blank form
            break;
        }

        $id = $get_post['id'];
        $sql = "SELECT * FROM " . BATTLE_TABLE . " WHERE  id=$id ";
        $result = lib::db_query($sql);
        $row = $result->fetch_assoc();  // will only be one row

        /*
          Certain characters like " and < and > are reserved in HTML,
          so will break the HTML if present in the data. The htmlspecialchars()function
          converts them all into HTML character entities &quot; and &lt; and &gt;
        */
        $name = htmlspecialchars($row['name']);
        $email = htmlspecialchars($row['email']);
        $age = $row['age'];
        $winner = json_decode($row['winner'], true);
        $scariness = $row['scariness'];
        $arena = $row['arena'];
        $favorite = json_decode($row['favorite'], true);
        $factor = htmlspecialchars($row['factor']);
        $confidence = $row['confidence'];
        $explanation = htmlspecialchars($row['explanation']);

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
        //(no task submitted)

        // Default values
        $winner = [];
        $arena = "";
        $favorite = "";
        $factor = [];
        $confidence = [];
        break;
}

//this function checks if each value was set. Otherwise, it loads a default value.

?>

<!DOCTYPE html>
<html>

<head>
    <title>Battle Form</title>
</head>

<body>
    <? if ($get_post['incomplete']) { ?>
        Your Form Submission was missing data <?= $get_post['incomplete'] ?>. Please fill out all fields.
        <br><br>
    <? } ?>
    <br>

    <a href="page_listing.php">Go To CRUD Listing Page</a> or create a new Database Record below.

    <br><br>

    <!-- This Form Submits to THIS file!  -->
    <form action="page_form.php" method="POST">
        <input type="hidden" name="task" value="save">
        <input type="hidden" name="id" value="<?= $id ?>">

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?= $name ?>">
        <br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= $email ?>">
        <br><br>

        <label for="age">Age:</label>
        <input type="number" id="age" name="age" value="<?= $age ?>">
        <br><br>

        Who would win:
        <br>
        <input type="checkbox" id="bear" name="winner[]" value="bear" <?=(in_array("bear", $winner) ? $sChecked : "") ?>>
        <label for="bear">Bear</label><br>
        <input type="checkbox" id="gorilla" name="winner[]" value="gorilla" <?=(in_array("gorilla", $winner) ? $sChecked : "") ?>>
        <label for="gorilla">Gorilla</label><br>
        <input type="checkbox" id="human" name="winner[]" value="human" <?=(in_array("human", $winner) ? $sChecked : "") ?>>
        <label for="human">Human</label>
        <br><br>

        <label for="scariness">How scary?:</label>
        <input type="range" id="scariness" name="scariness" min="0" max="100" value="<?= $scariness ?>">
        <br><br>

        <label for="arena">Arena:</label>
        <?= lib::menu_from_assoc_array("arena", $arena_options, '', $arena); ?>
        <br><br>

        <label for="favorite">Favorite to win (can choose multiple):</label>
        <br>
        <?= lib::menu_from_assoc_array("favorite[]", $favorite_options, '', $favorite, 'multiple'); ?>
        <br><br>

        Most important factor:<br>
        <input type="radio" id="factor1" name="factor" value="strength" <? if ("strength" == $factor) {
            echo $sChecked;
        } ?>>
        <label for="factor1">Strength</label><br>
        <input type="radio" id="factor2" name="factor" value="intelligence" <? if ("intelligence" == $factor) {
            echo $sChecked;
        } ?>>
        <label for="factor2">Intelligence</label><br>
        <input type="radio" id="factor3" name="factor" value="agility" <? if ("agility" == $factor) {
            echo $sChecked;
        } ?>>
        <label for="factor2">Agility</label>
        <br><br>

        Are you sure?<br>
        <input type="radio" id="confidence_y" name="confidence" value="1"<?= ("1" == $confidence ? $sChecked : "") ?>>
        <label for="confidence_y">Yes</label><br>
        <input type="radio" id="confidence_n" name="confidence" value="0" <?= ("0" == $confidence ? $sChecked : "") ?>>
        <label for="confidence_n">No</label>
        <br><br>

        <label for="explanation">Why:</label><br>
        <textarea id="explanation" name="explanation" rows="4" cols="50"><?= $explanation ?></textarea>
        <br><br>

        <input type="hidden" name="hidden" value="hidden">

        <button type="submit">Submit</button>
    </form>

</body>

</html>