<?
require 'init.php'; // database connection, etc

$order = array(
    "name" => "Name",
    "email" => "Email",
    "age" => "Age",
    "winner" => "Winner",
    "scariness" => "Scariness",
    "arena" => "Arena",
    "favorite" => "Favorite",
    "factor" => "Most Important Factor",
    "confidence" => "Confident?",
    "explanation" => "Why",
);//order of php array, change this to change order of table

// Selects all fields and all records from the table
$sql = "SELECT * FROM " . BATTLE_TABLE;
$result = lib::db_query($sql);

$num_rows = $result->num_rows;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Battle Form</title>
    <script type="text/javascript">

        function confirm_delete(id, name) {
            var choice = confirm("Are you sure you want to delete " + name + "?");

            if (choice == true) {
                window.location.href = "page_form.php?task=delete&id=" + id;
            }
        }
    </script>

</head>

<body>
    <a href="page_form.php">Go to the form. </a>
    <br><br>

    <? if (isset($get_post['deleted_message'])) { ?>
        <b>The DB record was sucessfuly deleted.</b>
        <br><br>
    <? } ?>

    <? if ($num_rows == 0) { ?>
        <b>No records were found in the database.</b>
    <? } else { ?>

        <b>Listing of Database Records:</b>

        <table width="" border="1" cellspacing="0" cellpadding="5">
            <th>
                <tr>
                    <?php foreach ($order as $key => $value) { ?>
                        <td><?= ucwords($value) ?></td>
                    <?php } ?>
                    <td>&nbsp;</td><!-- for the edit/delete links -->
                </tr>
            </th>
            <? while ($row = $result->fetch_assoc()) { ?>
                <tr valign="top">
                    <?php foreach ($order as $key => $value) { ?>
                        <td><?php
                        if ($key == "winner" || $key == "favorite") {
                            if (isset($row[$key])) {
                                $row[$key] = json_decode($row[$key], true);
                                foreach ($row[$key] as $val) { ?>
                                        <?= $val ?><br>
                                    <?php }
                            }
                        } else { ?>
                                <?= $row[$key] ?>
                            <?php } ?>
                        </td>
                    <?php } ?>
                    <td>
                        <a href="page_form.php?task=edit&id=<?= $row['id'] ?>">Edit</a>
                        &nbsp;&nbsp;|&nbsp;&nbsp;
                        <a href="#null" onclick="confirm_delete(<?= $row['id'] ?> , '<?= $row['name'] ?>')">Delete</a>
                    </td>
                </tr>
            <? } // end while ?>
        </table>

    <? } // end else ?>

</body>

</html>