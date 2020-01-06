<?php
$host = 'localhost'; // host
$username = 'ForumUser'; // username
$password = 'gibm2019'; // password
$database = 'Forum2'; // database

// mit Datenbank verbinden
$mysqli = new mysqli($host, $username, $password, $database);

// fehlermeldung, falls verbindung fehl schlägt.
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_error . ') ' . $mysqli->connect_error);
}


?>