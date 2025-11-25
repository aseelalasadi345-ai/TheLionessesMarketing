<?php
session_start();
if (!isset($_SESSION["userid"])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="header/header.css">
</head>
<body>

<div id="header-placeholder"></div>
<script>
fetch("header/header.php")
    .then(r => r.text())
    .then(d => document.getElementById("header-placeholder").innerHTML = d);
</script>

<div class="page-content">
    <h1>Welcome, <?php echo $_SESSION["username"]; ?>!</h1>
</div>

<div id="footer-placeholder"></div>
<script>
fetch("header/footer.php")
    .then(r => r.text())
    .then(d => document.getElementById("footer-placeholder").innerHTML = d);
</script>

</body>
</html>
