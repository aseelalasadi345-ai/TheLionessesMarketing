<?php
include '../db.php';

// Check POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $brand_name = $_POST['brand_name'] ?? '';
    $industry = $_POST['industry'] ?? '';

    $logoPath = null;

    if (!empty($_FILES["brand_logo"]["name"])) {

        $uploadDir = "../uploads/brand_logos/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES["brand_logo"]["name"]);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES["brand_logo"]["tmp_name"], $targetFile)) {
            $logoPath = "uploads/brand_logos/" . $fileName;
        } else {
            die("Error uploading logo!");
        }
    }

    $stmt = $conn->prepare("
        INSERT INTO brands (brand_name, industry, brand_logo_url)
        VALUES (?, ?, ?)
    ");

    $stmt->bind_param("sss", $brand_name, $industry, $logoPath);

    if ($stmt->execute()) {
        echo "<script>alert('Brand Added Successfully!'); window.location='adminPanel.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>