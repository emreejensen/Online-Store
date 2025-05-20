<?php
$hostname = "localhost";
$username = "ejensend_ej";
$password = "W3bT3ch@2002";
$dbname = "ejensend_4450project1";

// Use mysqli_connect to connect to the database
$dbc = mysqli_connect($hostname, $username, $password, $dbname) OR die("Cannot Connect to Database, ERROR...");
?>
