<?
// INIT file loads resources needed by all PHP pages in a Web Application.

/******************************************************************************************
Database Connection
******************************************************************************************/
define('DB_SERVER','localhost');
define('DB_USERNAME','csci488_fall24');
define('DB_PASSWORD','writeCode24');
define('DB_DATABASE','csci488_fall24');


$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit;
}

/******************************************************************************************
Database Tables
******************************************************************************************/
define('ACCOUNT_TABLE', 'cherepanov_final_account');
define('LOGONSTATE_TABLE', 'cherepanov_final_logonState');


/******************************************************************************************
Classes
******************************************************************************************/
require_once 'class_data_operations.php'; // Parent Class for ORM/AR functionality
require_once 'class_lib.php';     // Wrapper for useful utility functions

// Table-specific classes to implement ORM/AR
require_once 'class_account_table.php';


/******************************************************************************************
General Init Tasks
******************************************************************************************/
// Turn on PHP Sessions
session_start();

// Consolidate $_GET and $_POST super globals
$GET_POST    = array_merge($_GET,$_POST);

// No whitespace after the closing php tag because that generates script output.
?>