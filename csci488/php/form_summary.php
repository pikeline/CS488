<?php
$submitted_form_data = array_merge($_GET, $_POST);
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
                <td>Name</td>
                <td>Email</td>
                <td>Age</td>
                <td>Winner</td>
                <td>Scariness</td>
                <td>Arena</td>
                <td>Favorite</td>
                <td>Most important factor</td>
                <td>Confidence</td>
                <td>Why</td>
                <td>Hidden</td>
            </tr>
        </th>
        <tr>
            <td><?php echo $submitted_form_data['name'] ?></td>
            <td><?php echo $submitted_form_data['email'] ?></td>
            <td><?php echo $submitted_form_data['age'] ?></td>
            <td><?php echo $submitted_form_data['winner'] ?></td>
            <td><?php echo $submitted_form_data['scariness'] ?></td>
            <td><?php echo $submitted_form_data['arena'] ?></td>
            <td><?php echo $submitted_form_data['favorite'] ?></td>
            <td><?php echo $submitted_form_data['most_important_factor'] ?></td>
            <td><?php echo $submitted_form_data['confidence'] ?></td>
            <td><?php echo $submitted_form_data['why'] ?></td>
            <td><?php echo $submitted_form_data['hidden'] ?></td>
    </table>
</body>

</html>