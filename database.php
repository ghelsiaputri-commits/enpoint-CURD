<?php
$servername = "localhost";
$username = "root";      // default Laragon
$password = "";          // default kosong
$dbname = "endpoint";      // sesuaikan dengan nama database

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
