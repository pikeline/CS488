<?php
$submitted_form_data = array_merge($_GET, $_POST);
$order = array(
    "name" => "Name",
    "email" => "Email",
    "age" => "Age",
    "winner" => "Winner",
    "fear" => "Fear",
    "arena" => "Arena",
    "favorite" => "Favorite",
    "factor" => "Most important factor",
    "confidence" => "Confident",
    "explanation" => "Why",
    "hidden" => "Hidden"
)//order of php array, change this to change order of table
    ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form summary</title>
</head>

<body>
    <table>
        <th>
            <tr>
                <?php foreach ($order as $key => $value) { ?>
                    <td><?php echo ucwords($value) ?></td>
                <?php } ?>
            </tr>
        </th>
        <tr>
            <?php foreach ($order as $key => $value) { ?>
                <td><?php
                if ($key == "winner" || $key == "favorite") {
                    if (isset($submitted_form_data[$key])) {
                        foreach ($submitted_form_data[$key] as $val) { ?>
                                <?php echo $val ?><br>
                            <?php }
                    }
                } else { ?>
                        <?php echo $submitted_form_data[$key] ?>
                    <?php } ?>
                </td>
            <?php } ?>
    </table>
</body>

</html>
