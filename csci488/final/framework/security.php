<?php
require_once "framework/init.php";

if(!logon_state::check_valid_state()){
    setcookie("c_logon_token", "", time() - 1);
    header("Location: index.php?expired=1");
    exit();
}
?>