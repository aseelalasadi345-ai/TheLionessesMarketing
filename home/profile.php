<?php
session_start();
require "../db.php";

if (!isset($_SESSION["userid"])) {
    header("Location: login.php");
    exit();
}

$userId   = $_SESSION["userid"];
$username = $_SESSION["username"];
$email    = $_SESSION["email"];
$avatar   = $_SESSION["avatar"] ?: "uploads/default.png";
$msg = "";

// === UPDATE AVATAR ===
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["avatar"])) {

    if (!is_dir("uploads")) mkdir("uploads", 0777, true);

    $fileName = time() . "_" . basename($_FILES["avatar"]["name"]);
    $target   = "uploads/" . $fileName;

    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target)) {
        $stmt = $conn->prepare("UPDATE users SET avatar=? WHERE id=?");
        $stmt->bind_param("si", $target, $userId);
        $stmt->execute();

        $_SESSION["avatar"] = $target; // refresh session
        $avatar = $target;
        $msg = "Profile picture updated successfully!";
    } else {
        $msg = "Upload failed! Try a smaller image.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>
    <style>
        body { font-family: Arial; background:#e9f2ff; padding:40px; }
        .container {
            width:420px; margin:auto; background:white; padding:25px;
            border-radius:12px; box-shadow:0 0 20px rgba(0,0,0,.1);
        }
        .avatar {
            width:120px; height:120px; border-radius:50%;
            object-fit:cover; border:4px solid #071a69;
            display:block; margin:auto;
        }
        h1 { text-align:center; color:#071a69; margin-bottom:25px; }
        label { font-size:16px; display:block; margin-top:10px; }
        input[type="file"] { margin-top:10px; }
        button {
            margin-top:20px; width:100%; padding:12px; font-size:18px;
            background:#FF452A; color:white; border:none; border-radius:8px; cursor:pointer;
        }
        a { display:block; margin-top:20px; text-align:center; color:#071a69; text-decoration:none; }
        p { text-align:center; color:green; font-weight:bold; }
    </style>
</head>
<body>

<div class="container">
    <h1>My Profile</h1>

    <img src="<?php echo $avatar; ?>" class="avatar">

    <?php if ($msg) echo "<p>$msg</p>"; ?>

    <form method="post" enctype="multipart/form-data">
        <label>Change Profile Picture:</label>
        <input type="file" name="avatar" accept="image/*" required>
        <button type="submit">Update Avatar</button>
    </form>

    <a href="home.php">⬅ Back to Home</a>
</div>

</body>
</html>