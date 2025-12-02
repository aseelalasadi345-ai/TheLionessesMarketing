<?php
session_start();
?>
<header class="header">

    <div class="top">
        <div class="logo">Lionesses Marketing</div>
    </div>

    <nav class="nav">

        <div class="nav-center">
            <a href="home.php">Home</a>
            <a href="requests.php">Requests</a>
            <a href="brand.php">About Us</a>
            <a href="feedback.php">Feedback</a>
        </div>

        <div class="nav-user">
            <?php if (isset($_SESSION["username"])): ?>
                <span class="welcome">Hi, <?php echo htmlspecialchars($_SESSION["username"]) ; ?></span>
                <a class="logout" href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="signup.php">Sign Up</a>
            <?php endif; ?>
        </div>

    </nav>
</header>
