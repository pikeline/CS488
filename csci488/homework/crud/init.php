<?
// INIT file loads resources needed by multiple PHP pages in a Web Application.

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
define('BATTLE_TABLE', 'cherepanov_battle');
define("SHAKESPEARE_WORKS_TABLE", 'shakespeare_works');
define("SHAKESPEARE_CHAPTERS_TABLE", 'shakespeare_chapters');
define("SHAKESPEARE_PARAGRAPHS_TABLE", 'shakespeare_paragraphs');

/******************************************************************************************
Classes
******************************************************************************************/
require_once 'class_lib.php';   // Wrapper for useful utility functions


/******************************************************************************************
Consolidate and trim $_GET and $_POST super globals
******************************************************************************************/
$get_post    = array_merge($_GET,$_POST);

// No whitespace after the closing php tag below because that would generate script output
// which would be whitespace at the beginning of the HTML code returned to the browser.
?>