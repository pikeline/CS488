<?php
if(strpos($_SERVER["QUERY_STRING"], "task=edit") !== false){//editing string, can't use str_contains cuz not php 8
    $security = true;
}
require_once 'framework/init.php';

$err_msg = $GET_POST["err_msg"];
$task = $GET_POST["task"];
$now = time();

switch($task){
    case "save":
        $acc = new account();
        if(isset($GET_POST["acc_id"]) && $GET_POST["acc_id"] != ""){
            //update existing account
            $acc->load($GET_POST["acc_id"]);
            $pass = $acc->values["acc_password"];//save old password
            $old_email = $acc->values["acc_email"];
            $acc->update_from_form_submit();
            if(!isset($GET_POST["change_pass"])){//no change
                $acc->values["acc_password"] = $pass;
            }
            if(!validate_edit($acc, $old_email)){
                $task = "edit"; //workaround for redirect
                $id = $acc->get_id_value();
                $name = $acc->values["acc_name"];
                $email = $acc->values["acc_email"];
                break;
            }
            $acc->save();
            // update existing remember cookie
            setcookie("c_remember_email", $acc->values["acc_email"], $now + MAX_COOKIE_TIME);
            header("Location: account.php");
            exit();
            break;
        }
        else {
            //create new account
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
            break;
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
function validate_edit(account $acc, $old_email){
    global $err_msg;
    global $GET_POST;
    $name = trim($acc->values["acc_name"]);

    //find changes
    $name_changed = $name != $acc->values["acc_name"];
    $email_changed = $old_email != $acc->values["acc_email"];
    $pass_changed = isset($GET_POST["change_pass"]);

    //check only what was changed
    if ($name_changed){
        //validate name
        if (strlen($name) < 2){
            $err_msg = "Name needs to be at least two characters";
            return false;
        }
    }
    if ($email_changed){
        $existing = new account();
        $existing->load($acc->values["acc_email"], "acc_email");
        
        if ($existing->get_id_value() != null){
            $err_msg = "This email is already associated with an account";
            return false;
        }
    }
    if ($pass_changed){
        //validate password
        $password = trim($GET_POST["acc_password"]);
        if (strlen($password) < 5){
            $err_msg = "Password needs to be at least 5 characters";
            return false;
        }
        $verify = trim($GET_POST["password_verify"]);
        if ($password != $verify){
            $err_msg = "Passwords do not match";
            return false;
        }
        //rehash and update password
        $acc->values["acc_password"] = hash("sha256", $password);
    }
    //check if id matches logged in user's id
    $curr = logon_state::get_account_from_state();
    if ($curr->get_id_value() != $acc->get_id_value()){
        $err_msg = "You can only edit your own account";
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
<script>
function toggle_pass_block(){
    var pass = document.getElementById("pass");
    if(pass.hasAttribute("hidden")){
        pass.removeAttribute("hidden");
    }
    else{
        pass.setAttribute("hidden", "");
    }
}
</script>
<form method="post" action="final/signup.php">
    <input type="hidden" name="task" value="save">
    <input type="hidden" name="acc_id" value="<?= $id ?>">
    <label for="acc_name">Name</label><br>
    <input type="text" name="acc_name" placeholder="Name" required value="<?= $name?>"><br>
    <label for="acc_email">Email</label><br>
    <input type="email" name="acc_email" placeholder="Email" required value="<?= $email?>"><br>
    <div id="pass" <?= is_edit() ? "hidden" : ""?>>
        <label for="acc_password">Password</label><br>
        <input type="password" name="acc_password" placeholder="Password" value=""><br>
        <label for="password_verify">Verify Password</label><br>
        <input type="password" name="password_verify" placeholder="Confirm Password" value="">
    </div>
    <?php if(is_edit()){ ?>
        <label for="change_pass">Change Password</label>
        <input type="checkbox" onclick="toggle_pass_block()" name="change_pass" value="1">
    <?php } ?>
    <div <?= is_edit() ? "hidden" : ""?>>
        <br><br>
        <button type="submit">Sign Up</button>
        <button type="button" style="display:inline-block" onclick="window.location.href='final/index.php'">Go to Log In</button>
    </div>
    <div <?= is_edit() ? "" : "hidden"?>>
        <br>
        <button type="submit">Save</button>
        <button type="button" style="display:inline-block" onclick="window.location.href='final/account.php'">Cancel</button>
    </div>
    <span class="text-danger"><?= htmlspecialchars($err_msg) ?></span>
</form>
<?php
require_once 'framework/ssi_bottom.php';
?>
