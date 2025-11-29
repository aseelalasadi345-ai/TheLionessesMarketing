<?php
session_start();
require "db.php";

// LOGIN STATE
$isLogged = isset($_SESSION["username"]);

// AVATAR
$avatar = "img/default.png";
if ($isLogged && !empty($_SESSION["avatar"]) && file_exists($_SESSION["avatar"])) {
    $avatar = $_SESSION["avatar"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Home - Lionesses Marketing</title>
    <link rel="stylesheet" href="home.css?v=<?php echo time(); ?>">
</head>

<body>

    <header class="header">
        <nav class="nav">

            <!-- LEFT: LOGO + AVATAR -->
            <div class="left-side">
                <div class="logo">Lionesses Marketing</div>

                <?php if ($isLogged): ?>
                    <div class="avatar-box">
                        <img src="<?php echo $avatar; ?>" class="avatar">
                        <a href="profile.php" class="change-pic">Change Photo</a>
                    </div>
                    <span class="welcome">Hi, <?php echo htmlspecialchars($_SESSION["username"]); ?></span>
                <?php else: ?>
                    <span class="welcome">Welcome Guest</span>
                <?php endif; ?>
            </div>

            <!-- CENTER MENU -->
            <div class="menu">
                <a href="home.php" class="active">Home</a>
                <a href="request.html">Requests</a>
                <a href="brandTransformation.html">About Us</a>
                <a href="feedback.html">Feedback</a>
            </div>

            <!-- RIGHT SIDE BUTTONS -->
            <div class="actions">
                <?php if ($isLogged): ?>
                    <a href="logout.php" class="logout">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="login-btn">Login</a>
                    <a href="signup.php" class="signup-btn">Sign Up</a>
                <?php endif; ?>
            </div>

        </nav>
    </header>

   <section class="hero">
    <div class="hero-content">
        <h1>Your brand deserves structure</h1>
        <p>We create systems that customers recognize and trust.</p>
        <button class="cta">Browse</button>
    </div>

</section>


    <section class="how">
        <h2>How does it work?</h2>
        <p>Real-time analysis for faster, safer bussinesses.</p>
                    <img src="Gemini_Generated_Image_4zlr784zlr784zlr.png" class="how-img">

    </section>

    <section class="why">
        <h2>Why we are better than others</h2>
        <p>No hidden fees. No delays. More profit in less time.</p>
            <img src="Screenshot 2025-11-29 144107.png" class="hero-img">

    </section>

    <section class="benefits">
        <div>
            <h3>quickly</h3>
            <p>Decisions in minutes, not weeks.</p>
        </div>
        <div>
            <h3>convenient</h3>
            <p>Zero branch visits. Everything digital.</p>
        </div>
        <div>
            <h3>accessible</h3>
            <p>Fair access for everyone's budget.</p>
        </div>
    </section>

</body>

</html>