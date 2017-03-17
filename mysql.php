<?php

# Maurice Achtenhagen

/*
	mysql.php
	-----------------------------------------------
	This file is included ONLY by the back-end. It
	is required to make calls out to the database.
	-----------------------------------------------
*/

require_once('config.php');

if (empty(DB_SERVER) || empty(DB_USER)) {
	die('Application not configured.');
}

$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);

if ($mysqli->connect_error) {
	die('Unable to establish database connection: ' . $mysqli->connect_error);
}

$mysqli->set_charset('utf8');
