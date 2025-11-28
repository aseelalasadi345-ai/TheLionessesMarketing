<?php
include '../db.php';

$sql = "
    SELECT 
        p.project_id,
        p.project_title,
        bp.improvement_score,
        bp.transformation_status,
        m.detail_text,
        m.metric_value,
        m.type,
        t.main_image_url
    FROM projects p
    LEFT JOIN brand_project bp ON p.project_id = bp.project_id
    LEFT JOIN transformation_metrics m ON p.project_id = m.project_id
    LEFT JOIN brand_transformation_data t ON p.project_id = t.project_id
    WHERE bp.transformation_status IN ('Improved', 'Strongly Improved')
      AND p.is_published = 1
    ORDER BY bp.improvement_score DESC, p.project_id, m.sort_order
";

$result = $conn->query($sql);

$projects = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $id = $row['project_id'];

        if (!isset($projects[$id])) {
    $projects[$id] = [
        'id' => $row['project_id'],
        'title' => $row['project_title'],
        'score' => $row['improvement_score'],
        'status' => $row['transformation_status'],
        'image' => $row['main_image_url'],
        'before' => [],
        'after' => []
    ];
}

$metricText = $row['detail_text'];
$metricValue = $row['metric_value'];

$fullMetric = $metricValue !== null 
    ? "$metricText ($metricValue)"
    : $metricText;

if ($row['type'] === 'Before') {
    $projects[$id]['before'][] = $fullMetric;
} elseif ($row['type'] === 'After') {
    $projects[$id]['after'][] = $fullMetric;
}

    }
}

$projects_list = array_values($projects);

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Brand Transformation</title>
    <link rel="stylesheet" href="brandTransformation.css">
</head>
<body>

<header>
    <h1>Brand Transformation</h1>
    <p>Explore how our agency elevated brands before and after our intervention.</p>
    <a href="admin/addTransformation.php" class="adminOnly">+ ADD TRANSFORMATION</a>
</header>

<section class="projects-grid">

<?php if (empty($projects_list)): ?>
    <p>No transformation projects yet.</p>
<?php else: ?>
    <?php foreach ($projects_list as $project): ?>
        
        <a href="project_details.php?id=<?php echo $project['id']; ?>" class="project-card">

            <h2><?php echo htmlspecialchars($project['title']); ?></h2>
            <p class="score">Improvement Score: 
                <strong><?php echo htmlspecialchars($project['score']); ?>%</strong>
            </p>

            <div class="project-content">

                <div class="before">
                    <h3>Before</h3>
                    <?php foreach ($project['before'] as $metric): ?>
                        <p><?php echo htmlspecialchars($metric); ?></p>
                    <?php endforeach; ?>
                </div>

                <div class="after">
                    <h3>After</h3>
                    <?php foreach ($project['after'] as $metric): ?>
                        <p><?php echo htmlspecialchars($metric); ?></p>
                    <?php endforeach; ?>
                </div>

            </div>
        </a>

    <?php endforeach; ?>
<?php endif; ?>

</section>

</body>
</html>