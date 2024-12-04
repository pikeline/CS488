<?php
// Table-specific class - extends the data_operations class to apply to a specific database table.

class api_log extends data_operations {

  // Constructor - must have same name as class.
  function api_log() {

    $table = APILOG_TABLE;            // Constant defined in init.php
    $id_field = 'api_log_id';               // Primary Key field
    $id_field_is_ai = true;             // Is Primary Key Auto Increment?
    $fields = array(                    // Array of all non-PK fields
      'api_log_fk_acc_id',
      'api_log_access_time',
      'api_log_ipv4',
      'api_log_query'
    );

    // Parent class constructor
    // Sending it table-specific information enables this class to generate Active Record objects.
    parent::data_operations($table, $id_field, $id_field_is_ai, $fields);
  }

  /*
    This class inherits all methods in class_data_operations: load(), save(), load_from_form_submit(), etc
    That functionality is sufficient for operations on 1 Active Record.

    More complex data operations (JOINS, etc) require custom methods such as below.
    A table-specific ORM class such as this should contain all related data operations.
    This keeps the database logistics separate from the application logic in the PHP files that generate HTML.
  */
  
  public static function validate($token){
      $acc = new account();
      $acc->load($token, "acc_api_key");
      if ($acc->get_id_value() == null){//invalid token
          return false;
      }
      return true;
  }

  public static function get_total_hits(){
    $sql = "SELECT COUNT(*) FROM " . APILOG_TABLE;
    $result = lib::db_query($sql);
    $row = $result->fetch_row();//only 1
    return $row[0];
  }

  public static function most_recent_hit(){
    $sql = "SELECT api_log_access_time FROM " . APILOG_TABLE . " ORDER BY api_log_access_time DESC LIMIT 1";//most recent, only 1
    $result = lib::db_query($sql);
    $row = $result->fetch_row();
    return $row[0];
  }

  public static function get_works(){
    $sql = "SELECT COUNT(*) FROM " . APILOG_TABLE .
    " WHERE api_log_query NOT LIKE '%WORK%' AND api_log_query NOT LIKE '%ACT%' AND api_log_query NOT LIKE '%scene%'";
    $result = lib::db_query($sql);
    $row = $result->fetch_row();//only 1
    $good_work_hits = $row[0];
    $bad_work_hits = self::get_works_when_no_act() + self::get_works_when_no_scene();
    return $good_work_hits + $bad_work_hits;
  }
  //bad calls to api default to work
  private static function get_works_when_no_act(){
    $sql = "SELECT COUNT(*) FROM " . APILOG_TABLE .
    " WHERE api_log_query LIKE '%WORK%' AND api_log_query LIKE '%ACT%' AND api_log_query NOT LIKE '%scene%'";
    $result = lib::db_query($sql);
    $row = $result->fetch_row();//only 1
    return $row[0];
  }
  private static function get_works_when_no_scene(){
    $sql = "SELECT COUNT(*) FROM " . APILOG_TABLE .
    " WHERE api_log_query LIKE '%WORK%' AND api_log_query NOT LIKE '%ACT%' AND api_log_query LIKE '%scene%'";
    $result = lib::db_query($sql);
    $row = $result->fetch_row();//only 1
    return $row[0];
  }
  public static function get_acts(){
    $sql = "SELECT COUNT(*) FROM " . APILOG_TABLE .
    " WHERE api_log_query LIKE '%WORK%' AND api_log_query NOT LIKE '%ACT%' AND api_log_query NOT LIKE '%scene%'";
    $result = lib::db_query($sql);
    $row = $result->fetch_row();//only 1
    return $row[0];

  }
  public static function get_paragraphs(){
    $sql = "SELECT COUNT(*) FROM " . APILOG_TABLE .
    " WHERE api_log_query LIKE '%WORK%' AND api_log_query LIKE '%ACT%' AND api_log_query LIKE '%scene%'";
    $result = lib::db_query($sql);
    $row = $result->fetch_row();//only 1
    return $row[0];
  }
} //end class

?>
