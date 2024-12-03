<?php
class logon_state extends data_operations{
  function logon_state(){

  $table = LOGONSTATE_TABLE;            // Constant defined in init.php
  $id_field = 'logon_token';               // Primary Key field
  $id_field_is_ai = false;             // Is Primary Key Auto Increment?
  $fields = array(                    // Array of all non-PK fields
    'logon_fk_acc_id',
    'logon_creation_time',
    'logon_last_access_time',
    'logon_ipv4'
    );
    parent::data_operations($table, $id_field, $id_field_is_ai, $fields);
  }

  public static function create_state_from_acc(account $acc, $time){
    $state = new logon_state();
    $state->set_id_value(self::create_logon_token($acc, $time));
    $state->values["logon_fk_acc_id"] = $acc->get_id_value();
    $state->values["logon_ipv4"] = $_SERVER["REMOTE_ADDR"];
    $state->values["logon_creation_time"] = $time;
    $state->values["logon_last_access_time"] = $time;
    return $state;
  }

  public static function update_cookie($token){
    setcookie("c_logon_token", $token, time() + MAX_SESSION_TIME);
  }

  private static function create_logon_token(account $acc, $now){
    $hash = hash("md5", $acc->values["acc_email"] . $now);
    self::update_cookie($hash);
    return $hash;
  }
  public static function get_state_from_token(){
    $token = $_COOKIE["c_logon_token"];
    if ($token == null){
      return null;//no state found
    }
    $state = new logon_state();
    $state->load($token, "logon_token");
    self::update_cookie($token);
    $state->values["logon_last_access_time"] = time();
    $state->save();
    return $state;
  }
  public static function check_valid_state(){
    if(!isset($_COOKIE["c_logon_token"])){
      return false;
    }
    $state = new logon_state();
    $state->load($_COOKIE["c_logon_token"], "logon_token");
    if($state->get_id_value() == null){//state not in db somehow
      return false;
    }
    if($state->values["logon_last_access_time"] < time() - MAX_SESSION_TIME){//expired on server
      return false;
    }
    $state->values["logon_last_access_time"] = time();
    $state->save();
    self::update_cookie($_COOKIE["c_logon_token"]);
    return true;
  }
  public static function get_account_from_state(){
    $state = self::get_state_from_token();
    if($state == null){
      return null;
    }
    $acc = new account();
    $acc->load($state->values["logon_fk_acc_id"]);
    return $acc;
  }
}
?>
