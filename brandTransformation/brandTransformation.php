<?php
session_start();
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
while ($row = $result->fetch_assoc()) {

    $id = $row['project_id'];

    if (!isset($projects[$id])) {
        $projects[$id] = [
            'id' => $id,
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

    if ($metricText) {
        $fullMetric = $metricValue !== null ? "$metricText ($metricValue)" : $metricText;

        if ($row['type'] === 'Before') $projects[$id]['before'][] = $fullMetric;
        if ($row['type'] === 'After')  $projects[$id]['after'][]  = $fullMetric;
    }
}

$projects_list = array_values($projects);

$isLogged = isset($_SESSION["username"]);
$isAdmin  = isset($_SESSION["role"]) && $_SESSION["role"] === "Admin";

$avatar = "img/default.png";
if ($isLogged && !empty($_SESSION["avatar"]) && file_exists($_SESSION["avatar"])) {
    $avatar = $_SESSION["avatar"];
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Brand Transformation</title>

    <link rel="stylesheet" href="../home/home.css?v=<?php echo time(); ?>">

    <link rel="stylesheet" href="brandTransformation.css?v=<?php echo time(); ?>">
</head>

<body>

<div class="layout">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <h2 class="brand-title">Lionesses<br>Marketing</h2>

        <?php if ($isLogged): ?>
            <div class="user-area">
                <img src="<?php echo $avatar; ?>" class="avatar">
                <p class="username">Hi, <?= htmlspecialchars($_SESSION["username"]); ?></p>
                <a href="../home/profile.php" class="side-link">Change Photo</a>
            </div>
        <?php else: ?>
            <p class="username">Welcome Guest</p>
        <?php endif; ?>

        <nav class="side-menu">
            <a href="../home/home.php" class="side-link">🏠 Home</a>
            <a href="../request/request.html" class="side-link">📩 Requests</a>
            <a href="../home/aboutUs.html" class="side-link">💼 About Us</a>
            <a href="../home/feedback.html" class="side-link">⭐ Feedback</a>
            <a href="../home/contact.php" class="side-link">📞 Contact</a>

            <?php if ($isAdmin): ?>
                <a href="../admin/adminPanel.php" class="side-link admin-tag">🛠 Admin Panel</a>
            <?php endif; ?>
        </nav>

        <div class="extra-links">
            <a href="brandTransformation.php" class="extra-btn blue active">Brand Transformation</a>
            <a href="../sellingReadyProjects/sellingReadyProjects.php" class="extra-btn red">Ready Projects</a>
        </div>

        <?php if ($isLogged): ?>
            <a href="../home/logout.php" class="logout-btn">Logout</a>
        <?php else: ?>
            <a href="../home/login.php" class="logout-btn">Login</a>
        <?php endif; ?>
    </aside>

    <main class="content">

        <header class="page-header">
            <h1>Brand Transformation</h1>
            <p>Explore how brands completely evolved after working with our agency.</p>

            <?php if ($isAdmin): ?>
                <a href="../admin/addTransformation.php" class="adminOnly">+ ADD TRANSFORMATION</a>
            <?php endif; ?>
        </header>

        <section class="projects-grid">

            <?php if (empty($projects_list)): ?>
                <p>No transformation projects yet.</p>

            <?php else: ?>
                <?php foreach ($projects_list as $p): ?>
                    
                    <a href="project_details.php?id=<?= $p['id']; ?>" class="project-card">

                        <h2><?= htmlspecialchars($p['title']); ?></h2>

                        <p class="score">
                            Improvement Score: <strong><?= $p['score']; ?>%</strong>
                        </p>

                        <div class="project-content">

                            <div class="before">
                                <h3>Before</h3>
                                <?php foreach ($p['before'] as $b): ?>
                                    <p><?= htmlspecialchars($b); ?></p>
                                <?php endforeach; ?>
                            </div>

                            <div class="after">
                                <h3>After</h3>
                                <?php foreach ($p['after'] as $a): ?>
                                    <p><?= htmlspecialchars($a); ?></p>
                                <?php endforeach; ?>
                            </div>

                        </div>

                    </a>

                <?php endforeach; ?>
            <?php endif; ?>

        </section>

        <div class="request-box">
            <a href="../request/request.html" class="request-btn">✨ Request a Service</a>
        </div>

    </main>

</div>

<footer class="footer">
    <h3>Contact Us</h3>
    <p>Email: lionesses.marketing@gmail.com</p>
    <p>Phone: +961 03 140 618</p>
    <p>Instagram: @lionessesmarketing</p>
    <p><a class="footer-link" href="contact.php">Open Contact Page →</a></p>
</footer>

</body>
</html>