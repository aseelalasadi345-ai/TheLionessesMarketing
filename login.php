<?php
session_start();
require "db.php";

$msg = "";

// READ COOKIES IF THEY EXIST
$savedUser = $_COOKIE["RM_USER"] ?? "";
$savedPass = $_COOKIE["RM_PASS"] ?? "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $remember = isset($_POST["remember"]);

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
            $_SESSION["avatar"]   = $avatar;

          if ($remember) {
    setcookie("RM_USER", $username, time() + (86400 * 30), "/", "", false, true);
    setcookie("RM_PASS", $password, time() + (86400 * 30), "/", "", false, true);
} else {
    setcookie("RM_USER", "", time() - 3600, "/", "", false, true);
    setcookie("RM_PASS", "", time() - 3600, "/", "", false, true);
}


            header("Location: home.php");
            exit();
        } else {
            $msg = "❌ Wrong password!";
        }
    } else {
        $msg = "❌ User not found!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login - Lionesses Marketing</title>
    <link rel="stylesheet" href="ls.css?v=<?php echo time(); ?>">
</head>
<body>

<div class="auth-container">
    <h2>Welcome Back 🦁</h2>
    <p>Access your Lionesses account</p>

    <?php if ($msg): ?>
        <div class="error-box"><?= $msg ?></div>
    <?php endif; ?>

    <form method="post" autocomplete="on">
        <input type="text"
               id="username"
               name="username"
               placeholder="Username"
               autocomplete="username"
               value="<?= htmlspecialchars($savedUser) ?>"
               required>
<input type="password"
       id="password"
       name="password"
       placeholder="Password"
       autocomplete="current-password"
       data-pass="<?= htmlspecialchars($savedPass) ?>"
       required>


        <label class="remember">
            <input type="checkbox" name="remember" <?= $savedUser ? "checked" : "" ?>>
            Remember Me
        </label>

        <button type="submit" class="btn-primary">Login</button>
    </form>

    <p class="switch">Don't have an account?
        <a href="signup.php">Create one</a>
    </p>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const usernameInput = document.getElementById("username");
    const passwordInput = document.getElementById("password");
    const rememberBox   = document.querySelector('input[name="remember"]');
    const savedUser     = "<?= $savedUser ?>";
    const savedPass     = "<?= $savedPass ?>";

    // 🔹 ON PAGE LOAD → fields should be EMPTY, checkbox unchecked
    usernameInput.value = "";
    passwordInput.value = "";
    rememberBox.checked = false;

    // 🔹 When user types → if username matches cookie → autofill password + check the box
    usernameInput.addEventListener("input", function () {
        if (this.value.trim() === savedUser && savedUser !== "") {
            passwordInput.value = savedPass;
            rememberBox.checked = true;
        } else {
            passwordInput.value = ""; // clear password
            rememberBox.checked = false;
        }
    });
});
</script>


</body>
</html>
