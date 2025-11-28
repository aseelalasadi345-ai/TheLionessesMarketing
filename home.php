<?php
session_start();
require "db.php";

// BLOCK IF NOT LOGGED IN
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

// AVATAR CHECK
$avatar = "img/default.png";
if (isset($_SESSION["avatar"]) && $_SESSION["avatar"] !== "" && file_exists($_SESSION["avatar"])) {
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

<!-- ================= HEADER ================= -->
<header class="header">
    <nav class="nav">
        <!-- LEFT BLOCK -->
       <div class="left-side">
    <div class="logo">Lionesses Marketing</div>
    
    <div class="avatar-box">
        <img src="<?php echo $avatar; ?>" class="avatar">
        <a href="profile.php" class="change-pic">Change Photo</a>
    </div>

    <span class="welcome">Hi, <?php echo htmlspecialchars($_SESSION["username"]); ?></span>
</div>


        <!-- CENTER MENU -->
        <div class="menu">
            <a href="home.php" class="active">Home</a>
            <a href="request.html">Requests</a>
            <a href="brandTransformation.html">About Us</a>
            <a href="feedback.html">Feedback</a>
        </div>

        <!-- RIGHT LOGOUT -->
        <a href="logout.php" class="logout">Logout</a>
    </nav>
</header>
<!-- ================= END HEADER ================= -->

<!-- ================= HERO SECTION ================= -->
<section class="hero">
    <div class="hero-content">
        <h1>Quick home equity loans</h1>
        <p>
            Backed by analytics, smart approvals, and transparent rates.
            Designed to simplify the future of lending.
        </p>
        <button class="cta">Take a Loan</button>
        <button class="cta investor">Become an Investor</button>
    </div>
</section>

<!-- ================= HOW SECTION ================= -->
<section class="how">
    <h2>How does it work?</h2>
    <p>
        Our system analyzes financial patterns and behavior in real time,
        making decisions that are fast, accurate, and safer than banks.
    </p>
</section>

<!-- ================= WHY SECTION ================= -->
<section class="why">
    <h2>Why we are better than banks?</h2>
    <p>
        Banks charge you for inefficiency. We remove it. No hidden fees,
        no bureaucracy — just logic and velocity.
    </p>
</section>

<!-- ================= BENEFITS ================= -->
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
        <p>Fair, transparent access for everyone.</p>
    </div>
</section>

</body>
</html>
