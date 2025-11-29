<?php
session_start();

// Destroy all session data (log the user out)
$_SESSION = [];
session_unset();
session_destroy();

/*
 * DO NOT delete RM_USER / RM_PASS here.
 * These cookies are what power "Remember Me".
 * If you clear them on logout, there is nothing left to autofill.
 */

header("Location: login.php");
exit();
