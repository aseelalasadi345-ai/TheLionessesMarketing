<?php
// 1. CONNECT TO DATABASE
include '../db.php';  // FIXED PATH

// 2. CHECK FORM SUBMISSION
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect fields safely
    $title       = $_POST['project_title'];
    $type        = $_POST['project_type'];
    $desc        = $_POST['short_description'];
    $category    = $_POST['project_category'];
    $brand_id    = $_POST['brand_id'];
    $status      = $_POST['project_status'];
    $admin_id    = 202511212; // You can change this later using sessions
    $published   = 1;

    // -----------------------------
    // HANDLE FILE UPLOAD (project_file)
    // -----------------------------
    $project_file_path = NULL;

    if (!empty($_FILES['project_file']['name'])) {

        $upload_dir = "../uploads/projects/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        $file_name = time() . "_" . basename($_FILES['project_file']['name']);
        $target_path = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['project_file']['tmp_name'], $target_path)) {
            $project_file_path = $file_name;
        }
    }

    // -----------------------------
    // INSERT PROJECT INTO DATABASE
    // -----------------------------
    $stmt = $conn->prepare("
        INSERT INTO Projects 
        (project_title, project_type, short_description, is_published, created_by_admin_id, brand_id, project_status, project_category, project_file, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");

    $stmt->bind_param(
        "sssiiisss",
        $title,
        $type,
        $desc,
        $published,
        $admin_id,
        $brand_id,
        $status,
        $category,
        $project_file_path
    );

    if ($stmt->execute()) {
        echo "<script>alert('Project added successfully!'); window.location='adminPanel.php';</script>";
    } else {
        echo "<h3>Error: " . $stmt->error . "</h3>";
    }

    $stmt->close();
}

$conn->close();
?>