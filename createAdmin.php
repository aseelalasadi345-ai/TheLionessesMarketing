<?php
require "db.php";

$username = "rawandibrahim";
$email = "csrawand@gmail.com";
$password = password_hash("rawand11**5F", PASSWORD_DEFAULT);
$role = "Admin";

$stmt = $conn->prepare("INSERT INTO users (username, email, password_hash, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $username, $email, $password, $role);

if ($stmt->execute()) {
    echo "Admin created successfully!";
} else {
    echo "Error: " . $stmt->error;
}
?>