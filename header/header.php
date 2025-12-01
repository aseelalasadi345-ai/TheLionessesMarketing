<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="header">

    <!-- LEFT SIDE: Username + Logout -->
    <div class="left-info">
        Hi, <?= $_SESSION["username"]; ?> |
        <a class="logout" href="logout.php">Logout</a>
    </div>

    <!-- CENTER LOGO -->
    <div class="logo">LIONESSES MARKETING</div>

    <!-- RIGHT NAVIGATION -->
    <nav>
        <a href="home.php">Home</a>
        <a href="request.php">Requests</a>
        <a href="aboutus.html">About Us</a>
        <a href="feedback.php">Feedback</a>
    </nav>

</header>
