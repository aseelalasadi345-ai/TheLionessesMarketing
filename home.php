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

<div class="page-container">   <!-- NEW WRAPPER START -->

    <div class="left-block"></div> <!-- RED BLOCK NOW INSIDE WRAPPER -->

    <header class="header">
        <nav class="nav">

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

            <div class="menu">
                <a href="home.php" class="active">Home</a>
                <a href="request.html">Requests</a>
                <a href="brandTransformation.html">About Us</a>
                <a href="feedback.html">Feedback</a>
                    <a href="contact.php">Contact</a> <!-- NEW -->

            </div>

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
        <img src="Gemini_Generated_Image_4zlr784zlr784zlr.png" class="hero-img">
        <div class="hero-content">
            <div class="hero-card">
                <h1>Your brand deserves structure</h1>
                <p>We create systems that customers recognize and trust.</p>
                <button class="cta">Browse</button>
            </div>
        </div>
    </section>

    <section class="how">
        <h2>How it works</h2>
        <div class="info-box">
            We analyze your brand, identify weaknesses, and build a unified system that aligns visuals,
            communication, and customer interaction — giving your brand a structure that people trust.
        </div>
    </section>

    <section class="choose">
        <h2>Why you should choose us</h2>
        <div class="info-box">
            We don’t just design; we engineer brand identity. Our team blends creativity, data, and technology
            to deliver scalable marketing systems tailored to your growth.
        </div>
    </section>
    <section class="compare">
    <h2>Why choosing us is the smart move</h2>

    <div class="compare-box">
        <table>
            <tr>
                <th>Feature</th>
                <th>🚀 Lionesses Marketing</th>
                <th>⚠ Other Agencies</th>
            </tr>
            <tr>
                <td>Unified brand system</td>
                <td class="yes">✔</td>
                <td class="no">✖</td>
            </tr>
            <tr>
                <td>Data-driven decisions</td>
                <td class="yes">✔</td>
                <td class="no">✖</td>
            </tr>
            <tr>
                <td>Recognizable identity</td>
                <td class="yes">✔</td>
                <td class="no">Sometimes</td>
            </tr>
            <tr>
                <td>Scalable assets</td>
                <td class="yes">✔</td>
                <td class="no">✖</td>
            </tr>
            <tr>
                <td>Customer trust oriented</td>
                <td class="yes">✔</td>
                <td class="no">Rare</td>
            </tr>
        </table>
    </div>
</section>

<section class="benefits">
    <div class="benefit-box">
        <h3>QUICKLY</h3>
        <p>Decisions in minutes, not weeks.</p>
    </div>

    <div class="benefit-box">
        <h3>CONVENIENT</h3>
        <p>Zero branch visits. Everything digital.</p>
    </div>

    <div class="benefit-box">
        <h3>ACCESSIBLE</h3>
        <p>Fair access for everyone's budget.</p>
    </div>
</section>


</div> <!-- PAGE CONTAINER END -->
<footer class="footer">
    <h3>Contact Us</h3>

    <p>Email: lionesses.marketing@gmail.com</p>
    <p>Phone: +961 03 140 618</p>
    <p>Instagram: @lionessesmarketing</p>

    <!-- CLICKABLE CONTACT PAGE LINK -->
    <p><a href="contact.php" class="footer-link">Open Contact Form →</a></p>
</footer>



</body>

</html>