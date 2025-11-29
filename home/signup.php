<?php
require "../db.php";
$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $email    = trim($_POST["email"]);
    $password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);

    if (!is_dir("uploads")) mkdir("uploads", 0777, true);

    $avatarName = time() . "_" . basename($_FILES["avatar"]["name"]);
    $avatarPath = "uploads/" . $avatarName;
    move_uploaded_file($_FILES["avatar"]["tmp_name"], $avatarPath);

    $stmt = $conn->prepare(
        "INSERT INTO users (username, email, password, avatar) VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param("ssss", $username, $email, $password, $avatarPath);

    if ($stmt->execute()) {
        header("Location: login.php");
        exit();
    } else $msg = "⚠ Username or Email already exists!";
}
?>
<!DOCTYPE html>
<html>
<head>
<title>Sign Up - Lionesses Marketing</title>
<link rel="stylesheet" href="ls.css">
</head>
<body>

<div class="auth-container">
    <h2>Create Account</h2>
    <p>Join the Lionesses family</p>

    <?php if ($msg): ?>
        <div class="error-box"><?= $msg ?></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <label class="upload">Upload Profile Photo
            <input type="file" name="avatar" accept="image/*" required>
        </label>

        <button type="submit" class="btn-primary">Sign Up</button>
    </form>

    <p class="switch">Already have an account?
        <a href="login.php">Login here</a>
    </p>
</div>

</body>
</html>