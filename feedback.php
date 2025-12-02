<?php
require "db.php";
session_start();

if (!isset($_SESSION["userid"])) {
    header("Location: login.php");
    exit();
}

$msg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION["userid"];
    $rating = $_POST["rating"] ?? "Excellent";
    $comment = trim($_POST["comment"]);

    if ($comment === "") {
        $msg = "<p class='err'>Comment cannot be empty!</p>";
    } else {
        $stmt = $conn->prepare("INSERT INTO feedback (user_id, rating, comment) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $user_id, $rating, $comment);

        if ($stmt->execute()) {
            $msg = "<p class='success'>Thanks for your feedback! 🎉</p>";
        } else {
            $msg = "<p class='err'>Database error. Try again later.</p>";
        }

        $stmt->close();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Feedback – Lionesses Marketing</title>
<link rel="stylesheet" href="feedback.css?v=<?php echo time(); ?>">
</head>

<body>

<?php include __DIR__ . "/header/header.php"; ?> 

<div class="container">
    <h1>Share Your Feedback</h1>
    <?= $msg ?>

    <form action="" method="POST">
        <label>Rate Your Experience</label>
        <select name="rating" required>
            <option value="Excellent">Excellent ⭐⭐⭐⭐⭐</option>
            <option value="Good">Good ⭐⭐⭐⭐</option>
            <option value="Average">Average ⭐⭐⭐</option>
            <option value="Poor">Poor ⭐⭐</option>
        </select>

        <label>Write Your Feedback</label>
        <textarea name="comment" placeholder="Tell us what you loved or what we can improve…" required></textarea>

        <button class="btn" type="submit">Submit Feedback</button>
    </form>
</div>

<?php include __DIR__ . "/header/footer.php"; ?> 



</body>
</html>
