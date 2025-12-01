<?php
// admin/addBrandProject.php
include '../db.php';

// --------- HANDLE POST (insert) ----------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $brand_id            = $_POST['brand_id'] ?? null;
    $project_id          = $_POST['project_id'] ?? null;
    $transformation_status = $_POST['transformation_status'] ?? '';
    $improvement_score   = $_POST['improvement_score'] ?? null;
    $notes               = $_POST['notes'] ?? '';

    if (!$brand_id || !$project_id) {
        die("Brand and Project are required.");
    }

    $stmt = $conn->prepare("
    INSERT INTO brand_project 
        (brand_id, project_id, transformation_status, notes)
    VALUES (?, ?, ?, ?)
");

$stmt->bind_param(
    "iiss",   // 4 parameters → int, int, string, string
    $brand_id,
    $project_id,
    $transformation_status,
    $notes
);


    if ($stmt->execute()) {
        echo "<script>alert('Brand–Project link added successfully!'); 
              window.location='adminPanel.php';</script>";
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// --------- FETCH BRANDS & PROJECTS FOR THE FORM ----------
$brands   = [];
$projects = [];

// Brands
$res = $conn->query("SELECT brand_id, brand_name FROM brands ORDER BY brand_name");
while ($row = $res->fetch_assoc()) {
    $brands[] = $row;
}
$res->free();

// Only Transformation projects
$res2 = $conn->query("
    SELECT project_id, project_title 
    FROM projects 
    WHERE project_status = 'Completed'
    ORDER BY created_at DESC
");
while ($row = $res2->fetch_assoc()) {
    $projects[] = $row;
}
$res2->free();

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Link Brand to Project</title>
    <link rel="stylesheet" href="addBrandProject.css">
</head>
<body>

<div class="container">
    <h1>Link Brand to Project</h1>

    <form method="POST">
        <label>Brand</label>
        <select name="brand_id" required>
            <option value="">Select Brand</option>
            <?php foreach ($brands as $b): ?>
                <option value="<?php echo $b['brand_id']; ?>">
                    <?php echo htmlspecialchars($b['brand_name']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Project (Transformation)</label>
        <select name="project_id" required>
            <option value="">Select Project</option>
            <?php foreach ($projects as $p): ?>
                <option value="<?php echo $p['project_id']; ?>">
                    <?php echo htmlspecialchars($p['project_title']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label>Transformation Status</label>
        <select name="transformation_status" required>
            <option value="Ongoing">Ongoing</option>
            <option value="Improved">Improved</option>
            <option value="Underperforming">Underperforming</option>
        </select>

        <label>Notes</label>
        <textarea name="notes" rows="3" placeholder="Optional details..."></textarea>

        <button type="submit">Save Link</button>
    </form>
</div>

</body>
</html>