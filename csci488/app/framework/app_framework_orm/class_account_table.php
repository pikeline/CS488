<?php
// Table-specific class - extends the data_operations class to apply to a specific database table.

class account extends data_operations {

  // Constructor - must have same name as class.
  function account() {

    $table = PEOPLE_TABLE;              // Constant defined in init.php
    $id_field = 'ppl_id';               // Primary Key field
    $id_field_is_ai = true;             // Is Primary Key Auto Increment?
    $fields = array(                    // Array of all non-PK fields
      'ppl_name',
      'ppl_age',
      'ppl_states_visited'
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

  //////////////////////////////////////////////////////////////////////////////////////////////
  static function get_people_and_states($ppl_id='') {
    // Get people, with an array of the names of the States visited.
    // Returns all people if called with no primary key: get_people_with_states()

    $sql_where_condition = "1";  // all people
    if ($ppl_id !== '' ) {
      $sql_where_condition = "ppl_id= $ppl_id";
    }

    // LEFT JOIN - still get a person if there are no matches in states table
    $sql = "SELECT * FROM " . PEOPLE_TABLE . "
              LEFT JOIN " . STATES_TABLE . " ON ppl_states_visited LIKE Concat('%',st_abbr,'%')
              WHERE  $sql_where_condition ";
    $result = lib::db_query($sql);

    // Filter out the redundency from the JOIN
    $people = array();
    while ( $row = $result->fetch_assoc() ) {
      $people[$row['ppl_id']]['ppl_name'] = $row['ppl_name'];
      $people[$row['ppl_id']]['ppl_age'] = $row['ppl_age'];
      $people[$row['ppl_id']]['states_visited'][] = $row['st_name'];
    }
    return $people;
  }


} //end class

?>
