<?php
$submitted_form_data = array_merge($_GET, $_POST);
$order = array("name", "email", "age", "winner", "fear", "arena", "favorite", "factor", "confidence", "explanation", "hidden");//order of php array, change this to change order of table
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
                <?php foreach ($order as $key) { ?>
                    <td><?php echo ucwords($key) ?></td>
                <?php } ?>
            </tr>
        </th>
        <tr>
            <td><?php echo $submitted_form_data['name'] ?></td>
            <td><?php echo $submitted_form_data['email'] ?></td>
            <td><?php echo $submitted_form_data['age'] ?></td>
            <td><?php
            if (isset($submitted_form_data['winner'])) {
                foreach ($submitted_form_data['winner'] as $winner) {
                    echo $winner . "<br>";
                }
            }
            ?></td>
            <td><?php echo $submitted_form_data['fear'] ?></td>
            <td><?php echo $submitted_form_data['arena'] ?></td>
            <td><?php
            if (isset($submitted_form_data['favorite'])) {
                foreach ($submitted_form_data['favorite'] as $favorite) {
                    echo $favorite . "<br>";
                }
            }
            ?></td>
            <td><?php echo $submitted_form_data['factor'] ?></td>
            <td><?php echo $submitted_form_data['confidence'] ?></td>
            <td><?php echo $submitted_form_data['explanation'] ?></td>
            <td><?php echo $submitted_form_data['hidden'] ?></td>
    </table>
</body>

</html>
