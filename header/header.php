<?php
session_start();
?>
<header class="header">

    <div class="top">
        <div class="logo">Lionesses Marketing</div>
    </div>

    <nav class="head">

        <!-- CENTER NAV -->
        <div class="h">
            <a href="../homePage.php">Home</a>
            <a href="../request.html">Requests</a>
            <a href="../brandTransformation.html">About Us</a>
            <a href="../feedback.html">Feedback</a>
        </div>

        <!-- RIGHT NAV -->
        <div class="l">
            <?php if (isset($_SESSION["username"])): ?>
                <span class="welcome">Hi, <?php echo $_SESSION["username"]; ?></span>
                <a href="../logout.php">Logout</a>
            <?php else: ?>
                <a href="../login.html">Login</a>
                <a href="../signup.html">Sign Up</a>
            <?php endif; ?>
        </div>

    </nav>
</header>
