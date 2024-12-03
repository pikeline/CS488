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
define('APILOG_TABLE', 'cherepanov_final_api_log');
define("SHAKESPEARE_WORKS_TABLE", 'shakespeare_works');
define("SHAKESPEARE_CHAPTERS_TABLE", 'shakespeare_chapters');
define("SHAKESPEARE_PARAGRAPHS_TABLE", 'shakespeare_paragraphs');
define('PG_LIST_QUERY', "SELECT * FROM " . APILOG_TABLE);


/******************************************************************************************
Classes
******************************************************************************************/
require_once 'class_data_operations.php'; // Parent Class for ORM/AR functionality
require_once 'class_lib.php';     // Wrapper for useful utility functions

// Table-specific classes to implement ORM/AR
require_once 'class_account_table.php';
require_once 'class_logon_state_table.php';
require_once 'class_api_log_table.php';


/******************************************************************************************
General Init Tasks
******************************************************************************************/
// Turn on PHP Sessions
session_start();

// Consolidate $_GET and $_POST super globals
$GET_POST    = array_merge($_GET,$_POST);

// No whitespace after the closing php tag because that generates script output.

define("MAX_SESSION_TIME", 60*60); //1 hour
?>