<?php
$servername = "localhost";
$username   = "root";
$password   = "12345678";
$dbname     = "my-website";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// የካቴጎሪ ፊልተር ከተመረጠ
$category_filter = isset($_GET['category']) ? $_GET['category'] : '';

$sql = "SELECT jobs.*, categories.name AS category_name 
        FROM jobs 
        JOIN categories ON jobs.category_id = categories.id";

if (!empty($category_filter)) {
    $sql .= " WHERE jobs.category_id = " . intval($category_filter);
}

$sql .= " ORDER BY jobs.id DESC";
$result = $conn->query($sql);

// ካቴጎሪዎችን ለDropdown ማውጣት
$categories_result = $conn->query("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Portal - Find Vacancies</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; margin: 0; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; }
        .header { display: flex; justify-content: space-between; align-items: center; background: white; padding: 20px; border-radius: 10px; margin-bottom: 20px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }
        .header h1 { margin: 0; color: #1a73e8; }
        .post-btn { background: #1a73e8; color: white; padding: 10px 18px; text-decoration: none; border-radius: 6px; font-weight: bold; }
        .filter-box { background: white; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; gap: 10px; align-items: center; }
        select { padding: 8px 12px; border: 1px solid #ccc; border-radius: 5px; font-size: 15px; }
        .job-card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.05); border-left: 5px solid #1a73e8; }
        .job-card h3 { margin: 0 0 10px 0; color: #333; }
        .job-info { display: flex; gap: 15px; color: #666; font-size: 14px; margin-bottom: 12px; }
        .badge { background: #e8f0fe; color: #1a73e8; padding: 3px 8px; border-radius: 4px; font-weight: bold; }
        .deadline { color: #d93025; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>🔍 Available Job Vacancies</h1>
        <a href="post-job.php" class="post-btn">+ Post a New Job</a>
    </div>

    <!-- Filter Form -->
    <div class="filter-box">
        <label><b>Filter by Category:</b></label>
        <form method="GET" action="">
            <select name="category" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <?php
                if ($categories_result->num_rows > 0) {
                    while($cat = $categories_result->fetch_assoc()) {
                        $selected = ($category_filter == $cat['id']) ? 'selected' : '';
                        echo "<option value='" . $cat['id'] . "' $selected>" . $cat['name'] . "</option>";
                    }
                }
                ?>
            </select>
        </form>
    </div>

    <!-- Job Lists -->
    <?php
   if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<div class='job-card'>";
        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
        echo "<div class='job-info'>";
        echo "<span>🏢 <b>" . htmlspecialchars($row['company_name']) . "</b></span>";
        echo "<span>📍 " . htmlspecialchars($row['location']) . "</span>";
        echo "<span class='badge'>" . htmlspecialchars($row['category_name']) . "</span>";
        echo "<span class='badge'>" . htmlspecialchars($row['job_type']) . "</span>";
        echo "</div>";
        echo "<p>" . htmlspecialchars($row['description']) . "</p>";
        echo "<div class='deadline'>⏳ Deadline: " . htmlspecialchars($row['deadline']) . "</div>";
        echo "<a href='apply.php?job_id=" . $row['id'] . "' style='display:inline-block; margin-top:12px; background:#28a745; color:white; padding:8px 16px; text-decoration:none; border-radius:5px; font-weight:bold;'>Apply Now ➔</a>";
        echo "</div>";
    }
} else {
    echo "<div class='job-card'><p>No job vacancies found in this category.</p></div>";
}
$conn->close();
    ?>
</div>

</body>
</html>
