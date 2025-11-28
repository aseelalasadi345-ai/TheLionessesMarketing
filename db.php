<?php
$conn = new mysqli("localhost", "root", "", "TheLionessesMarketing");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
