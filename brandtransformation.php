<?php
session_start();
include 'db.php';

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
        $fullMetric = $metricValue !== null ? "$metricText ($metricValue)" : $metricText;

        if ($row['type'] === 'Before') $projects[$id]['before'][] = $fullMetric;
        if ($row['type'] === 'After')  $projects[$id]['after'][] = $fullMetric;
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
    <link rel="stylesheet" href="brandtransformation.css?v=<?php echo time(); ?>">
</head>
<body>

<header class="header">
    <div class="nav-container">

        <!-- LEFT SECTION -->
        <div class="nav-left">
            <?php if (isset($_SESSION["username"])): ?>
                <span class="welcome">Hi, <?= htmlspecialchars($_SESSION["username"]); ?></span>
                <a href="logout.php" class="logout">Logout</a>
            <?php else: ?>
                <a href="login.php" class="auth-btn">Login</a>
                <a href="signup.php" class="auth-btn">Sign Up</a>
            <?php endif; ?>
        </div>

        <!-- CENTER BRAND PAGE TITLE -->
        <div class="nav-center-title">Brand Transformation</div>

        <!-- RIGHT NAVIGATION -->
        <div class="nav-right">
            <a href="home.php">Home</a>
            <a href="request.php">Requests</a>
            <a href="sellingReadyProjects.php">Ready Projects</a>
            <a href="aboutus.html?run=1">About Us</a>
            <a href="feedback.php">Feedback</a>
        </div>

    </div>
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

<div class="request-box">
    <a href="../request/request.html" class="request-btn">
        ✨ Request a Service
    </a>
</div>
<footer class="footer-box">
    <h3>Contact Us</h3>

    <p>Email: lionesses.marketing@gmail.com</p>
    <p>Phone: +961 03 140 618</p>
    <p>Instagram: @lionessesmarketing</p>

    <p>
        <a class="footer-link"
           href="https://wa.me/96103140618?text=Hello%20Lionesses%20Marketing,%20I%20need%20help%20with%20..."
           target="_blank">
           Open WhatsApp Chat →
        </a>
    </p>
</footer>

</body>
</html>