<?php
include "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $pass = trim($_POST["password"]);

    if ($username === "" || $email === "" || $pass === "") {
        die("All fields are required!");
    }

    $exists = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $exists->bind_param("s", $email);
    $exists->execute();
    $exists->store_result();

    if ($exists->num_rows > 0) {
        die("Email already registered.");
    }

    $hashed = password_hash($pass, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed);

    if ($stmt->execute()) {
        header("Location: login.html");
        exit();
    }
}
?>
