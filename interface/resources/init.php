<?php
/*

File: Initialisation file
Description: Does any initial data processing, sets constants and requires() any files
Author: ScottSmudger for Group 11
URL: https://github.com/ScottSmudger/GPIO-Door

*/

// Set constants
define("ROOT", dirname(__DIR__));
define("DS", DIRECTORY_SEPARATOR);
define("CLASS_DIR", ROOT . DS . "resources" . DS . "classes" . DS);
define("RESOURCE_DIR", ROOT . DS . "resources" . DS);
// Get config settings
require_once(RESOURCE_DIR . "config.php");
// Get database class
require_once(CLASS_DIR . "database.class.php");

// Create the object
$database = new database(new mysqli($CONFIG["db_host"], $CONFIG["db_user"], $CONFIG["db_password"], $CONFIG["db_database"]));

?>
