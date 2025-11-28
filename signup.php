<?php
require "db.php";
$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $email    = trim($_POST["email"]);
    $password = password_hash(trim($_POST["password"]), PASSWORD_DEFAULT);

    // ensure uploads folder exists
    if (!is_dir("uploads")) mkdir("uploads", 0777, true);

    // filename becomes uploads/123123_pic.png
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
    } else {
        $msg = "Username or Email already exists!";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Sign Up</title></head>
<body>

<h1>Sign Up</h1>
<?php if ($msg) echo "<p style='color:red;'>$msg</p>"; ?>

<form method="post" enctype="multipart/form-data">
  Username:<br>
  <input type="text" name="username" required><br><br>

  Email:<br>
  <input type="email" name="email" required><br><br>

  Password:<br>
  <input type="password" name="password" required><br><br>

  Profile Picture:<br>
  <input type="file" name="avatar" accept="image/*" required><br><br>

  <button type="submit">Create Account</button>
</form>

<a href="login.php">Back to Login</a>
</body>
</html>
