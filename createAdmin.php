<?php
require "db.php";

$username = "admin";
$email = "admin@example.com";
$password = password_hash("Admin1234", PASSWORD_DEFAULT);
$role = "Admin";

$stmt = $conn->prepare("INSERT INTO users (username, email, password_hash, role) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $username, $email, $password, $role);

if ($stmt->execute()) {
    echo "Admin created successfully!";
} else {
    echo "Error: " . $stmt->error;
}
?>