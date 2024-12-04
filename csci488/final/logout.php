<?php
require_once "framework/init.php";

if(isset($_COOKIE["c_logon_token"])){
  setcookie("c_logon_token", "", time() - 1);
}

header("Location: index.php");
?>