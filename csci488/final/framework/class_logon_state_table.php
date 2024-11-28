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
}
?>
