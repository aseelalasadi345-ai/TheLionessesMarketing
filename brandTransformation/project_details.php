<?php
include 'db_connect.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: brand_transformation.php");
    exit();
}

$project_id = (int)$_GET['id'];

$stmt = $conn->prepare("
    SELECT 
        p.project_title,
        p.short_description,
        bp.improvement_score,
        m.detail_text,
        m.type
    FROM Projects p
    LEFT JOIN brand_project bp ON p.project_id = bp.project_id
    LEFT JOIN Transformation_Metrics m ON p.project_id = m.project_id
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
        if ($first) {
            $project_details = [
                'title' => $row['project_title'],
                'description' => $row['short_description'],
                'score' => $row['improvement_score']
            ];
            $first = false;
        }

        if ($row['detail_text']) {
            if ($row['type'] === 'Before') {
                $metrics['before'][] = $row['detail_text'];
            } else {
                $metrics['after'][] = $row['detail_text'];
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
    <title><?php echo htmlspecialchars($project_details['title']); ?></title>
    <link rel="stylesheet" href="projectDetails.css">
</head>
<body>

<header>
    <h1><?php echo htmlspecialchars($project_details['title']); ?></h1>
    <p class="score">Improvement Score: 
        <strong><?php echo htmlspecialchars($project_details['score']); ?>%</strong>
    </p>
</header>

<section class="details-section">
    <h2>Project Summary</h2>
    <p><?php echo htmlspecialchars($project_details['description']); ?></p>

    <div class="metrics-comparison">

        <div class="before-details">
            <h3>Before</h3>
            <ul>
                <?php foreach ($metrics['before'] as $m): ?>
                    <li><?php echo htmlspecialchars($m); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="after-details">
            <h3>After</h3>
            <ul>
                <?php foreach ($metrics['after'] as $m): ?>
                    <li><?php echo htmlspecialchars($m); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>

    </div>

    <a href="brand_transformation.php">← Back</a>
</section>

</body>
</html>