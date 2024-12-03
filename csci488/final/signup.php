<?php
require_once 'framework/init.php';

$err_msg = $GET_POST["err_msg"];
$task = $GET_POST["task"];
$now = time();

switch($task){
    case "save":
        if(isset($GET_POST["acc_id"]) && $GET_POST["acc_id"] != ""){
            //update existing account
            $acc = new account();
            $acc->load($GET_POST["acc_id"]);
            $pass = $acc->values["acc_password"];
            $acc->update_from_form_submit();
            $acc->values["acc_password"] = $pass;//don't change password
            if(!validate_edit($acc)){
                $task = "edit"; //workaround for redirect
                $id = $acc->get_id_value();
                $name = $acc->values["acc_name"];
                $email = $acc->values["acc_email"];
                break;
            }
            $acc->save();
            //delete existing remember cookie
            setcookie("c_remember_email", $acc->values["acc_email"], $now - 1);
            header("Location: account.php");
            exit();
        }
        else {
            $acc = new account();
            $acc->load_from_form_submit();
    
            if(!validate($acc)){
                break;
            }
    
            $acc->values["acc_password"] = hash("sha256", trim($acc->values["acc_password"]));
            $acc->values["acc_api_key"] = create_api_key();
    
            $acc->save();
            //update acc logon state info
            $login = logon_state::create_state_from_acc($acc, $now);
            $login->save();
            //delete existing remember cookie
            setcookie("c_remember_email", $acc->values["acc_email"], $now - 1);
            header("Location: account.php");
            exit();
        }

        break;
    case "edit":
        $login = logon_state::get_state_from_token();
        if ($login == null){
            break;//show empty form
        }
        $acc = new account();
        $acc->load($login->values["logon_fk_acc_id"]);
        $id = $acc->get_id_value();
        $name = $acc->values["acc_name"];
        $email = $acc->values["acc_email"];

        break;
    default:
        $id = "";
        $name = "";
        $email = "";
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
function validate_edit(account $acc){
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
        echo "a".$existing->get_id_value() != $acc->get_id_value()."a";
        $err_msg = "This email is already associated with an account";
        return false;
    }
    return true;
}


function create_api_key(){
    global $now;
    return hash("sha256", $now . "ows" . $_POST["acc_email"]);
}
function is_edit(){
    global $task;
    return $task == "edit";
}
?>
<?php
require_once 'framework/ssi_top.php';
?>
<form method="post" action="final/signup.php">
    <input type="hidden" name="task" value="save">
    <input type="hidden" name="acc_id" value="<?= $id ?>">
    <label for="acc_name">Name</label><br>
    <input type="text" name="acc_name" placeholder="Name" required value="<?= $name?>"><br>
    <label for="acc_email">Email</label><br>
    <input type="email" name="acc_email" placeholder="Email" required value="<?= $email?>"><br>
    <div <?= is_edit() ? "hidden" : ""?>>
        <label for="acc_password">Password</label><br>
        <input type="password" name="acc_password" placeholder="Password" value=""><br>
        <label for="password_verify">Verify Password</label><br>
        <input type="password" name="password_verify" placeholder="Confirm Password" value=""><br><br>
        <button type="submit">Sign Up</button>
        <button type="button" style="display:inline-block" onclick="window.location.href='final/index.php'">Go to Log In</button>
    </div>
    <div <?= is_edit() ? "" : "hidden"?>>
        <br>
        <button type="submit">Save</button>
        <button type="button" style="display:inline-block" onclick="window.location.href='final/account.php'">Cancel</button>
    </div>
    <span class="text-danger"><?= "&nbsp;" . htmlspecialchars($err_msg) ?></span>
</form>
<?php
require_once 'framework/ssi_bottom.php';
?>
