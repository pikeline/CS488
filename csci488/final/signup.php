<?php
require_once 'framework/init.php';

$err_msg = "";
$task = $_POST["task"];
$now = time();

switch($task){
    case "save":
        $acc = new account();
        $acc->load_from_form_submit();

        if(!validate($acc)){
            break;
        }

        $acc->values["acc_password"] = hash("sha256", trim($acc->values["acc_password"]));
        $acc->values["acc_api_key"] = create_api_key();

        $acc->save();

        //update acc logon state info
        $login = new logon_state();
        $login->values["logon_token"] = create_logon_token();
        $login->values["logon_fk_acc_id"] = $acc->get_id_value();
        $login->values["logon_ipv4"] = $_SERVER["REMOTE_ADDR"];
        $login->values["logon_creation_time"] = $now;
        $login->values["logon_last_access_time"] = $now;

        $login->save();
        //TODO: redirect to secure pages
        header("Location: index.php");
        break;
    default:
        break;
}

function validate(account $acc){
    global $err_msg;
    global $GET_POST;
    $name = trim($acc->values["acc_name"]);
    if (strlen($name) < 2){
        $err_msg = "Name needs to be at least two characters";
        return false;
    }

    $existing = new account();
    $existing->load($acc->values["acc_email"], "acc_email");
    if ($existing->get_id_value() != null){
        $err_msg = "This email is already associated with an account";
        return false;
    }
    $password = trim($acc->values["acc_password"]);
    if (strlen($password) < 5){
        $err_msg = "Password needs to be at least 5 characters";
        return false;
    }
    $verify = trim($GET_POST["password_verify"]);
    if ($password != $verify){
        $err_msg = "Passwords do not match";
        return false;
    }
    return true;
}

function create_api_key(){
    global $now;
    return hash("sha256", $now . "ows" . $_POST["acc_email"]);
}
function create_logon_token(){
    global $now;
    return hash("md5", $_POST["acc_email"] . $now);
}
?>
<?php
require_once 'framework/ssi_top.php';
?>
<form method="post" action="app/signup.php">
    <input type="hidden" name="task" value="save">
    <input type="hidden" name="acc_id" value="">
    <label for="acc_name">Name</label><br>
    <input type="text" name="acc_name" placeholder="Name" required value="<?= htmlspecialchars($GET_POST["acc_name"] ?? "")?>"><br>
    <label for="acc_email">Email</label><br>
    <input type="email" name="acc_email" placeholder="Email" required value="<?= htmlspecialchars($GET_POST["acc_email"] ?? "") ?>"><br>
    <label for="acc_password">Password</label><br>
    <input type="password" name="acc_password" placeholder="Password" value="<?= htmlspecialchars($GET_POST["acc_password"] ?? "") ?>"><br>
    <label for="password_verify">Verify Password</label><br>
    <input type="password" name="password_verify" placeholder="Confirm Password" value="<?= htmlspecialchars($GET_POST["password_verify"] ?? "") ?>"><br><br>
    <button type="submit">Sign Up</button><span class="text-danger"><?= "&nbsp;" . htmlspecialchars($err_msg) ?></span>
</form>
<?php
require_once 'framework/ssi_bottom.php';
?>
