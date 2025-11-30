<?php
session_start();
require "../db.php";

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $message = trim($_POST["message"]);

    if ($name !== "" && $email !== "" && $message !== "") {
        $stmt = $conn->prepare("
            INSERT INTO contact_requests(fullname,email,phone,message)
            VALUES(?,?,?,?)
        ");
        $stmt->bind_param("ssss", $name, $email, $phone, $message);
        $stmt->execute();
        $msg = "Your request has been submitted successfully!";
    } else {
        $msg = "Please fill the required fields.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Contact Us - Lionesses Marketing</title>
<link rel="stylesheet" href="contact.css?v=<?php echo time(); ?>">
</head>

<body>

<div class="contact-block"></div>

<header class="header">
    <nav class="nav">
        <div class="logo">Lionesses Marketing</div>
        <div class="menu">
            <a href="home.php">Home</a>
            <a href="contact.php" class="active">Contact</a>
        </div>
    </nav>
</header>

<section class="contact-container">
    <h2>Get in Touch</h2>

    <?php if ($msg): ?>
        <p class="status"><?php echo $msg; ?></p>
    <?php endif; ?>

    <form method="POST" class="contact-form">
        <input type="text" name="fullname" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="text" name="phone" placeholder="WhatsApp Number">
        <textarea name="message" placeholder="How can we help you?" required></textarea>
        <button type="submit">Submit</button>
    </form>

    <!-- DIRECT CONTACT (STATIC INFO) -->
    <div class="direct-contact">
        <h3>Contact us directly</h3>
        <p>Email: <a href="mailto:lionesses.marketing@gmail.com">lionesses.marketing@gmail.com</a></p>
        <p>WhatsApp: <a target="_blank" href="https://wa.me/96103140618">+961 03 140 618</a></p>
    </div>

    <!-- 🚀 ACTION BUTTONS -->
  <div class="contact-actions">

    <!-- WHATSAPP BUTTON ONLY -->
    <a href="https://wa.me/96103140618?text=Hello%20Lionesses%20Marketing,%20I%20need%20help%20with%20..."
       class="btn whatsapp-btn" target="_blank">
       WhatsApp Us
    </a>

</div>


</section>

</body>
</html>