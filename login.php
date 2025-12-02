<?php
session_start();
require "db.php";

$msg = "";
$savedUsers = isset($_COOKIE["RM_USERS"])
    ? json_decode($_COOKIE["RM_USERS"], true)
    : [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $identifier = trim($_POST["username"]); //aseel 7taytelek hay lal email
    $password   = trim($_POST["password"]);
    $remember   = isset($_POST["remember"]);
    $stmt = $conn->prepare("
        SELECT id, username, email, password, avatar, role
        FROM users
        WHERE username=? OR email=?
    ");
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $dbUser, $dbEmail, $hash, $avatar, $role);
        $stmt->fetch();

        if (password_verify($password, $hash)) {

            $_SESSION["userid"]   = $id;
            $_SESSION["username"] = $dbUser;
            $_SESSION["email"]    = $dbEmail;
            $_SESSION["avatar"]   = $avatar;
            $_SESSION["role"]     = $role;

            if ($remember) {
                $savedUsers[$dbUser] = $password;
            } else {
                unset($savedUsers[$dbUser]);
            }

            setcookie("RM_USERS", json_encode($savedUsers), time() + 86400 * 30, "/", "", false, true);

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
<body class="login-body">

<div class="auth-container">
    <h2>Welcome Back 🦁</h2>
    <p>Access your Lionesses account</p>

   <?php if ($msg): ?>
    <div class="error-box">
        <?= $msg ?>
        <?php if ($msg === "❌ User not found!"): ?>
            <br>
            <span style="font-size:14px;">
                Don't have an account?
                <a href="signup.php" style="color:#002395; font-weight:bold;">Sign up now</a>
            </span>
        <?php endif; ?>
    </div>
<?php endif; ?>


    <form method="post" autocomplete="off">
        <input type="text"
               id="username"
               name="username"
               placeholder="Username or Email"
               required>

        <input type="password"
               id="password"
               name="password"
               placeholder="Password"
               required>

        <label class="remember">
            <input type="checkbox" name="remember">
            Remember Me
        </label>

        <button type="submit" class="btn-primary">Login</button>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const username = document.getElementById("username");
    const password = document.getElementById("password");
    const remember = document.querySelector('input[name="remember"]');

    const saved = <?= json_encode($savedUsers); ?>;

    username.value = "";
    password.value = "";
    remember.checked = false;

    username.addEventListener("input", function () {
        const typed = this.value.trim();
        if (saved[typed] !== undefined) {
            password.value = saved[typed];
            remember.checked = true;
        } else {
            password.value = "";
            remember.checked = false;
        }
    });
});
</script>

</body>
</html>
