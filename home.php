<?php
session_start();
require "db.php";

$isLogged = isset($_SESSION["username"]);

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

    <div class="layout">

        <!-- LEFT BLUE COLUMN -->
        <aside class="sidebar">
            <h2 class="brand-title">Lionesses<br>Marketing</h2>

            <?php if ($isLogged): ?>
                <div class="user-area">
                    <img src="<?php echo $avatar; ?>" class="avatar">
                    <p class="username">Hi, <?php echo htmlspecialchars($_SESSION["username"]); ?></p>
                    <a href="profile.php" class="side-link">Change Photo</a>
                </div>
            <?php else: ?>
                <p class="username">Welcome Guest</p>
            <?php endif; ?>

            <nav class="side-menu">
                <a href="home.php" class="side-link active">🏠 Home</a>
                <a href="request.php" class="side-link">📩 Requests</a>
                <a href="aboutus.html?run=1" class="side-link">👀 About Us</a>
                <a href="feedback.php" class="side-link">⭐ Feedback</a>
                <a href="contact.php" class="side-link">📞 Contact</a>
            </nav>


            <?php if ($isLogged && $_SESSION["role"] === "Admin"): ?>
                <a href="../admin/adminPanel.php" class="side-link admin-tag">🛠 Admin Panel</a>
            <?php endif; ?>
        

            <div class="extra-links">
                <a href="brandTransformation.php" class="extra-btn blue">Brand Transformation</a>
                <a href="sellingReadyProjects.php" class="extra-btn red">Ready Projects</a>
            </div>

<?php if ($isLogged): ?>
    <a href="logout.php" class="logout-btn">Logout</a>
<?php else: ?>
    <a href="login.php" class="auth-box-red">Login</a>
    <a href="signup.php" class="auth-box-red">Sign Up</a>
<?php endif; ?>





        </aside>

        <main class="content">

            <section class="hero">
                <img src="Gemini_Generated_Image_4zlr784zlr784zlr.png" class="hero-img">
                <div class="hero-box">
                    <h1>Your brand deserves structure</h1>
                    <p>We create systems that customers recognize and trust.</p>
                    <a href="sellingReadyProjects.php" class="cta">Browse</a>
                </div>
            </section>

            <section class="info-section">
                <h2>How it works</h2>
                <div class="info-card">
                    We analyze your brand, identify weaknesses, and build a unified system that aligns visuals,
                    communication, and customer interaction — giving your brand a trusted identity.
                </div>
            </section>

            <section class="info-section">
                <h2>Why choose us</h2>
                <div class="info-card">
                    We don’t just design; we engineer a solid identity for your business. Strategy, creativity,
                    and technology combined to deliver results.
                </div>
            </section>

            <section class="compare">
                <h2>Why we are different</h2>
                <a href="brandtransformation.php" class="brand-btn">Explore Brand Transformation</a>

                <div class="compare-box">
                    <table>
                        <tr>
                            <th>Feature</th>
                            <th>🚀 Lionesses</th>
                            <th>⚠ Others</th>
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
                            <td>Customer trust focus</td>
                            <td class="yes">✔</td>
                            <td class="no">Rare</td>
                        </tr>
                    </table>
                </div>
            </section>

            <!-- BENEFITS -->
            <section class="benefits">
                <div class="benefit">QUICKLY<p>Decisions in minutes</p>
                </div>
                <div class="benefit">CONVENIENT<p>Everything digital</p>
                </div>
                <div class="benefit">ACCESSIBLE<p>For all budgets</p>
                </div>
            </section>

        </main>

    </div>

    <footer class="footer">
        <h3>Contact Us</h3>
        <p>Email: lionesses.marketing@gmail.com</p>
        <p>Phone: +961 03 140 618</p>
        <p>Instagram: @lionessesmarketing</p>
        <p><a class="footer-link" href="contact.php">Open Contact Page →</a></p>
    </footer>

</body>

</html>