<?php
$security = true;
require_once 'framework/init.php';

$table_names = array(
    "acc_id" => "ID",
    "acc_name" => "Name",
    "acc_email" => "Email",
    "acc_api_key" => "API Key"
);

$acc = new account();
$state = logon_state::get_state_from_token();
$acc->load($state->values["logon_fk_acc_id"]);
?>
<?php
require_once 'framework/ssi_top.php';
?>

<h1>Welcome</h1>
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
<br>
<button type="button" style="display:inline-block" onclick="window.location.href='final/signup.php?task=edit'">Edit Profile</button>
<button type="button" style="display:inline-block" onclick="window.location.href='final/stats.php'">Stats</button>

<?php
require_once 'framework/ssi_bottom.php';
?>