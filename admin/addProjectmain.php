<!DOCTYPE html>
<html>
<head>
    <title>Add Project</title>
    <link rel="stylesheet" href="addProject.css">
</head>
<body>

<div class="container">

    <h1>Add New Project</h1>

    <form action="http://localhost/The%20Lionesses'%20Marketing/admin/addProject.php" method="POST" enctype="multipart/form-data">

        <label>Project Title</label>
        <input type="text" name="project_title" required>

        <label>Project Type</label>
<select name="project_type" required>
    <option>Website</option>
    <option>Ads</option>
    <option>Poster</option>
    <option>Social Media</option>
    <option>Branding</option>
</select>

        <label>Short Description</label>
        <textarea name="short_description" rows="4" required></textarea>

        <label>Project Category</label>
        <input type="text" name="project_category" placeholder="e.g., Awareness Campaign, Rebranding Project...">

        <label>Brand</label>
        <select name="brand_id" required>
            <option value="">Select Brand</option>
            <?php
include '../db.php';
$result = $conn->query("SELECT brand_id, brand_name FROM brands");

while ($row = $result->fetch_assoc()) {
    echo "<option value='".$row['brand_id']."'>".$row['brand_name']."</option>";
}
?>

        </select>

        <label>Project Status</label>
        <select name="project_status">
            <option value="Ongoing">Ongoing</option>
            <option value="Completed">Completed</option>
            <option value="Ready to Sell">Ready to Sell</option>
        </select>

        <label>Upload Project File / Image</label>
        <input type="file" name="project_file" accept="image/*,.pdf,.zip">

        <button type="submit">Add Project</button>
    </form>

</div>

</body>
</html>