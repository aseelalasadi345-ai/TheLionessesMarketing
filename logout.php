<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Remove Remember Me cookies
if (isset($_COOKIE["RM_USER"])) {
    setcookie("RM_USER", "", time() - 3600, "/");
}
if (isset($_COOKIE["RM_PASS"])) {
    setcookie("RM_PASS", "", time() - 3600, "/");
}

// Redirect user to login page
header("Location: login.php");
exit();
?>
