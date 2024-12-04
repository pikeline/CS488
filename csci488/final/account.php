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

$api_prefix = "https://csci.lakeforest.edu/~cherepanovds/csci488/final/api.php?token=" . $acc->values["acc_api_key"];
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
<h1>Sample API Calls</h1>
<br>
<div>
    <h3>Get Works</h3>
    <div>
        <a href="<?= $api_prefix ?>"><?= $api_prefix ?></a>
    </div>
    <br>
    <h3>Get Acts</h3>
    <div>
        <a href="<?= $api_prefix ?>&work=hamlet"><?= $api_prefix ?>&work=hamlet</a>
    </div>
    <br>

    <h3>Get Paragraphs</h3>
    <div>
        <a href="<?= $api_prefix ?>&work=hamlet&act=1&scene=1"><?= $api_prefix ?>&work=hamlet&act=1&scene=1</a>
    </div>
    <br>
    <br>
    <br>
</div>

<?php
require_once 'framework/ssi_bottom.php';
?>