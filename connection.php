<?php
$hostname = "localhost";
$username = "";
$password = "";
$dbname = "";

// Use mysqli_connect to connect to the database
$dbc = mysqli_connect($hostname, $username, $password, $dbname) OR die("Cannot Connect to Database, ERROR...");
?>
