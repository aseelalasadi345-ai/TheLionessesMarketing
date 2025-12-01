<?php
// admin/addTransformation.php
include '../db.php';

// ---------- HANDLE POST ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $project_id = $_POST['project_id'] ?? null;

    if (!$project_id) {
        die("Project is required.");
    }

    if (empty($_FILES['main_image']['name'])) {
        die("Please choose an image file.");
    }

    $uploadDir = "../uploads/transformations/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName   = time() . "_" . basename($_FILES['main_image']['name']);
    $targetFile = $uploadDir . $fileName;

    if (!move_uploaded_file($_FILES['main_image']['tmp_name'], $targetFile)) {
        die("Error uploading image.");
    }

    // Path to store in DB (relative to project root)
    $imageUrl = "uploads/transformations/" . $fileName;

    $stmt = $conn->prepare("
        INSERT INTO brand_transformation_data (project_id, main_image_url)
        VALUES (?, ?)
    ");

    $stmt->bind_param("is", $project_id, $imageUrl);

    if ($stmt->execute()) {
        echo "<script>alert('Transformation image saved!'); 
              window.location='adminPanel.php';</script>";
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// ---------- FETCH ONLY TRANSFORMATION PROJECTS ----------
$projects = [];

$res = $conn->query("
    SELECT p.project_id, p.project_title
    FROM projects p
    INNER JOIN brand_project bp ON p.project_id = bp.project_id
    WHERE bp.transformation_status IN ('Improved', 'Strongly Improved')
      AND p.project_status = 'Completed'
    ORDER BY p.created_at DESC
");

while ($row = $res->fetch_assoc()) {
    $projects[] = $row;
}
$res->free();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Transformation Image</title>
    <link rel="stylesheet" href="addTransformation.css">
</head>
<body>

<div class="container">
    <h1>Add Transformation Image</h1>

    <form method="POST" enctype="multipart/form-data">

        <label>Project (Transformation)</label>
        <select name="project_id" required>
            <option value="">Select Project</option>
            <?php foreach ($projects as $p): ?>
                <option value="<?php echo $p['project_id']; ?>">
                    <?php echo htmlspecialchars($p['project_title']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Main Image</label>
        <input type="file" name="main_image" accept="image/*" required>

        <button type="submit">Save Transformation</button>
    </form>
</div>

</body>
</html>