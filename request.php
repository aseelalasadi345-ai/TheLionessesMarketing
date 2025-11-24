<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name     = htmlspecialchars($_POST["name"]);
    $email    = htmlspecialchars($_POST["email"]);
    $brand    = htmlspecialchars($_POST["brand"]);
    $industry = htmlspecialchars($_POST["industry"]);
    $message  = htmlspecialchars($_POST["message"]);

    $to = "aseelalasadi345@gmail.com"; 
    $subject = "New Brand Audit Request – $brand";
    
    $body = "
    A new brand audit request has been submitted:\n\n
    Name: $name\n
    Email: $email\n
    Brand: $brand\n
    Industry: $industry\n
    Message:\n$message
    ";

    $headers = "From: $email\r\n";

    if (mail($to, $subject, $body, $headers)) {
        echo "<h2 style='font-family: Poppins; text-align:center; margin-top:50px; color:#22c55e;'>Your audit request has been sent successfully! 🌟</h2>";
        echo "<p style='text-align:center; color:#fff;'>We will reply within 24–48 hours.</p>";
    } else {
        echo "<h2 style='font-family: Poppins; text-align:center; margin-top:50px; color:#ef4444;'>Something went wrong. Try again.</h2>";
    }

} else {
    echo "Invalid request.";
}

?>

</body>
</html>