<?php
$host = "localhost";    /* Host name */
$user = "root";         /* User */
$password = "";         /* Password */
$dbname = "appointment";   /* Database name */

// Create connection
$con = mysqli_connect($host, $user, $password,$dbname);
$con->set_charset("utf8");
// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

