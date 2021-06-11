<?php

// Connecting to the database
$servername = "localhost";
$username = "root";
$password = "";
$database = "customers_sfbank";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);

// Die if connection was not successful
if (!$conn){
        die("Unable to connect to the database due to the following error: ".mysqli_connect_error());
}

?>