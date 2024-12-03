<?php
require_once "framework/init.php";
require_once "framework/ssi_top.php";

if(logon_state::check_valid_state()){
    header("Location: account.php");
    exit();
}

$task = $GET_POST["task"];
$now = time();
$err_msg = isset($GET_POST["expired"]) ? "Session expired." : "";

switch($task){
    case "login":
        $acc = new account();
        $acc->load($_POST["email"], "acc_email");
        $pass = hash("sha256", trim($_POST["password"]));

        if ($acc == null || $acc->values["acc_password"] != $pass){//does not exist or wrong pass
            $err_msg = "Invalid credentials";
            break;
        }
        //create a new state since you are logging in
        $login = logon_state::create_state_from_acc($acc, $now);
        $login->save();
        if ($_POST["remember"] == 1){
            setcookie("c_remember_email", $acc->values["acc_email"], $now + 60 * 60 * 24 * 30); //30 days
        }
        else{
            setcookie("c_remember_email", $acc->values["acc_email"], $now - 1);//forget
        }
        header("Location: account.php");
        exit();
        break;
    default:
        break;
}

function get_saved_email(){
    if (isset($_COOKIE["c_remember_email"])){
        return $_COOKIE["c_remember_email"];
    }
    return "";
}
?>
<form method="post" action="final/index.php">
    <input type="hidden" name="task" value="login">
    <label for="email">Email</label><br>
    <input type="email" name="email" required value="<?= get_saved_email();?>"><br>
    <label for="password">Password</label><br>
    <input type="password" name="password" required><br>
    <label for="remember">Remember Me?</label>
    <input type="checkbox" name="remember" value="1" <?= isset($_COOKIE["c_remember_email"]) ? "checked" : "";?>><br><br>
    <div>
        <button type="submit" style="display:inline-block">Log In</button>
        <button type="button" style="display:inline-block" onclick="window.location.href='final/signup.php'">Go to Sign Up</button>
    </div>
    <span class="text-danger"><?= $err_msg ?></span>
</form>
<?php
require_once "framework/ssi_bottom.php";
?>
