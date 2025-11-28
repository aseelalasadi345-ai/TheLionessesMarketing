<?php
session_start();
require "db.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT id, email, password, avatar FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $email, $hash, $avatar);
        $stmt->fetch();

        if (password_verify($password, $hash)) {
            $_SESSION["userid"]   = $id;
            $_SESSION["username"] = $username;
            $_SESSION["email"]    = $email;
            $_SESSION["avatar"]   = $avatar; // STORED!
            header("Location: home.php");
            exit();
        } else $msg = "Wrong password!";
    } else $msg = "User not found!";
}
?>

<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>

<h1>Login</h1>
<?php if ($msg) echo "<p style='color:red;'>$msg</p>"; ?>

<form method="post">
  Username:<br>
  <input type="text" name="username" required><br><br>

  Password:<br>
  <input type="password" name="password" required><br><br>

  <button type="submit">Login</button>
</form>

<a href="signup.php">Create Account</a>
</body>
</html>
