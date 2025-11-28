<?php
include '../db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $project_id     = $_POST['project_id'];
    $type           = $_POST['type'];
    $detail_text    = $_POST['detail_text'];
    $metric_value   = $_POST['metric_value'] ?? null;
    $sort_order     = $_POST['sort_order'];

    // --------------------------
    // OPTIONAL FILE UPLOAD
    // --------------------------
    $metric_file_path = NULL;

    if (!empty($_FILES["metric_file"]["name"])) {

        $uploadDir = "../uploads/metrics/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES["metric_file"]["name"]);
        $targetFile = $uploadDir . $fileName;

        if (move_uploaded_file($_FILES["metric_file"]["tmp_name"], $targetFile)) {
            $metric_file_path = "uploads/metrics/" . $fileName;
        }
    }

    $stmt = $conn->prepare("
        INSERT INTO transformation_metrics 
        (project_id, type, detail_text, metric_value, sort_order, metric_file)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param(
        "isssis",
        $project_id,
        $type,
        $detail_text,
        $metric_value,
        $sort_order,
        $metric_file_path
    );

    if ($stmt->execute()) {
        echo "<script>alert('Metric Added Successfully!'); window.location='addMetric.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>