<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<header class="header">

    <div class="left-info">
        Hi, <?= $_SESSION["username"]; ?> |
        <a class="logout" href="logout.php">Logout</a>
    </div>

    <div class="logo">LIONESSES MARKETING</div>

    <nav>
        <a href="home.php">Home</a>
        <a href="request.php">Requests</a>
        <a href="aboutus.html">About Us</a>
        <a href="feedback.php">Feedback</a>
    </nav>

</header>
