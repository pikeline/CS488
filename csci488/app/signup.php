<?php
require_once 'framework/init.php';

$err_msg = "";
$task = $_POST["task"];

switch($task){
    case "save":
        $acc = new account();
        $acc->load_from_form_submit();

        if(!validate($acc)){
            break;
        }

        $acc->values["acc_password"] = hash("sha256", trim($acc->values["acc_password"]));
        $acc->values["acc_creation_time"] = time();
        $acc->values["acc_ipv4"] = $_SERVER["REMOTE_ADDR"];

        $acc->save();

        header("Location: account.php?id=" . $acc->get_id_value());
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
