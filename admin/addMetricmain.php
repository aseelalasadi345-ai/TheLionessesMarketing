<!DOCTYPE html>
<html>
<head>
    <title>Add Transformation Metric</title>
    <link rel="stylesheet" href="addMetric.css">
</head>
<body>

<div class="container">

    <h1>Add Metric</h1>

    <form action="http://localhost/The%20Lionesses'%20Marketing/admin/addMetric.php" 
          method="POST" 
          enctype="multipart/form-data">

        <label>Project</label>
        <select name="project_id" required>
            <option value="">Select Project</option>
            <?php
                include '../db.php';
                $q = $conn->query("SELECT project_id, project_title FROM projects WHERE project_status='Completed'");
                while($row = $q->fetch_assoc()){
                    echo "<option value='{$row['project_id']}'>{$row['project_title']}</option>";
                }
            ?>
        </select>

        <label>Metric Type</label>
        <select name="type" required>
            <option value="">Select Type</option>
            <option value="Before">Before</option>
            <option value="After">After</option>
        </select>

        <label>Metric Description</label>
        <textarea name="detail_text" rows="3" required></textarea>

        <label>Metric Value (Number)</label>
        <input type="number" name="metric_value">

        <label>Sort Order</label>
        <input type="number" name="sort_order" value="1" required>

        <label>Upload Supporting File (Optional)</label>
        <input type="file" name="metric_file" accept="image/*,.pdf,.zip,.csv,.xlsx">

        <button type="submit">Add Metric</button>
    </form>

</div>

</body>
</html>