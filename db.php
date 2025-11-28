<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "TheLionessesMarketing";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("DB CONNECTION FAILED: " . $conn->connect_error);
}
?>