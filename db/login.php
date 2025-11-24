<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"]);
    $pass  = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $username, $hashedPassword);
        $stmt->fetch();

        if (password_verify($pass, $hashedPassword)) {
            $_SESSION["userid"] = $id;
            $_SESSION["username"] = $username;

            header("Location: homePage.html");
            exit();
        } else {
            die("Incorrect password.");
        }

    } else {
        die("Email not found.");
    }

}
?>
