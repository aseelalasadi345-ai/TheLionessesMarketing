<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ready Projects Store</title>

    <link rel="stylesheet" href="sellingReadyProjects.css?v=<?php echo time(); ?>">
    <script defer src="sellingReadyProjects.js"></script>
</head>

<body>

<header class="header">

    <div class="top">
        <div class="logo">Lionesses Marketing</div>
    </div>

    <nav class="nav">

        <div class="nav-center">
            <a href="home.php">Home</a>
            <a href="request.html">Requests</a>
            <a href="aboutUs.html">About Us</a>
            <a href="feedback.html">Feedback</a>
        </div>

        <div class="nav-user">
            <?php if (isset($_SESSION["username"])): ?>
                <span class="welcome">Hi, <?php echo htmlspecialchars($_SESSION["username"]); ?></span>
                <a class="logout" href="logout.php">Logout</a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="signup.php">Sign Up</a>
            <?php endif; ?>
        </div>

    </nav>
</header>

<div class="page-content">

    <section class="products">
        <h2 class="section-title">Ready Projects For Sale</h2>

        <div class="cards">

            <!-- CARD 1 -->
            <div class="card">
                <a href="supermarkt.html">
                    <img src="super.jpg" alt="SuperMarkt">
                </a>
                <h3>SuperMarkt</h3>

                <a href="supermarkt.html" class="view-btn">View Details</a>

                <a class="contact-btn"
                   href="https://wa.me/96103140618?text=Hello%20Lionesses%20Marketing,%20I%20want%20to%20order%20the%20SuperMarket%20project.">
                    Contact Us To Buy
                </a>
            </div>

            <!-- CARD 2 -->
            <div class="card">
                <a href="apartment.html">
                    <img src="apartment.jpg" alt="Apartment Project">
                </a>
                <h3>🔥 Apartment (Special Offer) 🔥</h3>

                <div class="timer" data-days="6"></div>

                <a href="apartment.html" class="view-btn">View Details</a>

                <a class="contact-btn"
                   href="https://wa.me/96103140618?text=Hello%20Lionesses,%20I%20want%20to%20order%20the%20Apartment%20project.">
                    Contact Us To Buy
                </a>
            </div>

            <!-- CARD 3 -->
            <div class="card">
                <a href="juice.html">
                    <img src="Juicee.jpg" alt="Juice Project">
                </a>
                <h3>Juice Project</h3>

                <a href="juice.html" class="view-btn">View Details</a>

                <a class="contact-btn"
                   href="https://wa.me/96103140618?text=Hello%20Lionesses,%20I%20want%20to%20order%20the%20Juice%20Project.">
                    Contact Us To Buy
                </a>
            </div>

        </div>
    </section>

</div>

<footer class="footer">
    <h3>Contact Us</h3>
    <p>Email: lionesses.marketing@gmail.com</p>
    <p>Phone: +961 03 140 618</p>
    <p>Instagram: @lionessesmarketing</p>
</footer>

</body>
</html>