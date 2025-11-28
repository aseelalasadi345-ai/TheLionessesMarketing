<?php
include '../db.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: brand_transformation.php");
    exit();
}

$project_id = (int)$_GET['id'];

// ------------------------------
// FETCH PROJECT + METRICS + BRAND PROJECT + TRANSFORMATION IMAGE
// ------------------------------
$stmt = $conn->prepare("
    SELECT 
        p.project_title,
        p.short_description,
        p.project_file,
        p.project_image,
        bp.improvement_score,
        bp.transformation_status,
        t.main_image_url,
        m.detail_text,
        m.metric_value,
        m.metric_file,
        m.type,
        m.sort_order
    FROM projects p
    LEFT JOIN brand_project bp ON p.project_id = bp.project_id
    LEFT JOIN brand_transformation_data t ON p.project_id = t.project_id
    LEFT JOIN transformation_metrics m ON p.project_id = m.project_id
    WHERE p.project_id = ?
    ORDER BY m.sort_order
");

$stmt->bind_param("i", $project_id);
$stmt->execute();
$result = $stmt->get_result();

$project_details = [];
$metrics = ['before' => [], 'after' => []];

if ($result->num_rows > 0) {

    $first = true;

    while ($row = $result->fetch_assoc()) {

        // FIRST ROW → Contains general project info
        if ($first) {
            $project_details = [
                'title'       => $row['project_title'],
                'description' => $row['short_description'],
                'score'       => $row['improvement_score'],
                'status'      => $row['transformation_status'],
                'file'        => $row['project_file'],
                'image'       => $row['project_image'],
                't_image'     => $row['main_image_url'],
            ];
            $first = false;
        }

        // METRICS
        if ($row['detail_text']) {

            $metricDisplay = "<strong>{$row['detail_text']}</strong>";

            if ($row['metric_value'] !== null) {
                $metricDisplay .= " <span class='metric-value'>({$row['metric_value']})</span>";
            }

            // SHOW FILE DIRECTLY IN PAGE
            if (!empty($row['metric_file'])) {

    $safeFile = urlencode($row['metric_file']);
    $filePath = "../" . ltrim($row['metric_file'], '/');
    $ext = strtolower(pathinfo($row['metric_file'], PATHINFO_EXTENSION));

    if (in_array($ext, ['png','jpg','jpeg','webp','gif'])) {
        $metricDisplay .= "<br><img src='$filePath' class='metric-image'>";
    } elseif ($ext === 'pdf') {
        $metricDisplay .= "<br><iframe src='$filePath' class='metric-pdf'></iframe>";
    } else {
        $metricDisplay .= "<br><a href='$filePath' download class='metric-download'>📎 Download File</a>";
    }
}

            if ($row['type'] === 'Before') {
                $metrics['before'][] = $metricDisplay;
            } else {
                $metrics['after'][] = $metricDisplay;
            }
        }
    }

} else {
    header("Location: brand_transformation.php");
    exit();
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($project_details['title']); ?></title>
    <link rel="stylesheet" href="projectDetails.css">
</head>
<body>

<header>
    <h1><?= htmlspecialchars($project_details['title']); ?></h1>

    <p class="score">
        <strong>Improvement Score:</strong> <?= htmlspecialchars($project_details['score']); ?>%
    </p>

    <p class="status">
        <strong>Status:</strong> <?= htmlspecialchars($project_details['status']); ?>
    </p>
</header>

<section class="details-section">

    <h2>Project Summary</h2>
    <p><?= htmlspecialchars($project_details['description']); ?></p>

    <!-- PROJECT FILES SECTION -->
    <div class="project-files">

        <!-- Project Image -->
        <?php if (!empty($project_details['image'])): ?>
            <h3>Project Main Image</h3>
            <img src="../uploads/projects/<?= $project_details['image']; ?>" class="project-main-image">
        <?php endif; ?>

        <!-- The project file -->
        <?php if (!empty($project_details['file'])): ?>
            <h3>Project File</h3>
            <?php 
                $fileExt = strtolower(pathinfo($project_details['file'], PATHINFO_EXTENSION));
                $filePath = "../uploads/projects/{$project_details['file']}";

                if (in_array($fileExt, ['png','jpg','jpeg','gif','webp'])) {
                    echo "<img src='$filePath' class='project-main-image'>";
                } elseif ($fileExt === 'pdf') {
                    echo "<iframe src='$filePath' class='project-pdf'></iframe>";
                } else {
                    echo "<a href='$filePath' download class='btn-download'>📎 Download File</a>";
                }
            ?>
        <?php endif; ?>
    </div>

    <!-- BEFORE / AFTER -->
    <div class="metrics-comparison">

        <div class="before-details">
            <h3>Before</h3>
            <ul>
                <?php foreach ($metrics['before'] as $m): ?>
                    <li><?= $m ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="after-details">
            <h3>After</h3>
            <ul>
                <?php foreach ($metrics['after'] as $m): ?>
                    <li><?= $m ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

    </div>

    <a href="http://localhost/The%20Lionesses'%20Marketing/brandTransformation/brandTransformation.php" class="back-btn">← Back</a>

</section>

</body>
</html>