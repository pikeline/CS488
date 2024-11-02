<?php
require_once 'framework/init.php';

$table_names = array(
    "acc_id" => "ID",
    "acc_name" => "Name",
    "acc_email" => "Email",
    "acc_password" => "Password Hash",
    "acc_ipv4" => "IP",
    "acc_creation_time" => "Creation Timestamp"
);

$acc = new account();
$acc->load($GET_POST["id"]);
?>
<?php
require_once 'framework/ssi_top.php';
?>

<div <?= isset($GET_POST["id"]) ? "" : "hidden" ?>>
    <h1>Account successfully created</h1>
    <table style="border: 1px solid white; padding: 0px; border-spacing: 10px;">
        <thead>
            <tr style="padding: 0px">
                <?php foreach ($table_names as $key => $value) { ?>
                    <th style="border: 1px solid white;"><?= htmlspecialchars($value) ?></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <tr style="padding: 0px;">
                <?php foreach ($table_names as $key => $value) { 
                    if($key == "acc_id"){ ?>
                        <td style="border: 1px solid white;"><?= htmlspecialchars($acc->get_id_value()) ?></td>
                    <?php }
                    else{ ?>
                        <td style="border: 1px solid white;"><?= htmlspecialchars($acc->values[$key]) ?></td>
                    <?php }
                } ?>
            </tr>
        </tbody>
    </table>
</div>
<div <?= isset($GET_POST["id"]) ? "hidden" : "" ?>>
    You shouldn't be here :(
</div>

<?php
require_once 'framework/ssi_bottom.php';
?>