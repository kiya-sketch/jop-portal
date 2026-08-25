<?php
$servername = "localhost";
$username   = "root";
$password   = "12345678";
$dbname     = "my-website";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// ማመልከቻዎችን ከነተዛማጅ የስራ ዘርፋቸው በJOIN ማውጣት
$sql = "SELECT applications.*, jobs.title AS job_title, jobs.company_name 
        FROM applications 
        JOIN jobs ON applications.job_id = jobs.id 
        ORDER BY applications.id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submitted Job Applications</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; margin: 0; padding: 20px; }
        .container { max-width: 1000px; margin: 0 auto; background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { color: #1a73e8; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #1a73e8; color: white; }
        tr:hover { background-color: #f5f5f5; }
        .back-btn { display: inline-block; margin-bottom: 15px; background: #6c757d; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <a href="index.php" class="back-btn">⬅ Back to Home</a>
    <h2>📋 Received Job Applications</h2>

    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Applicant Name</th>
                    <th>Applied For</th>
                    <th>Company</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Experience</th>
                    <th>Applied Date</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $count = 1;
                while($row = $result->fetch_assoc()): 
                ?>
                    <tr>
                        <td><?php echo $count++; ?></td>
                        <td><b><?php echo htmlspecialchars($row['applicant_name']); ?></b></td>
                        <td><?php echo htmlspecialchars($row['job_title']); ?></td>
                        <td><?php echo htmlspecialchars($row['company_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['experience_level']); ?></td>
                        <td><?php echo htmlspecialchars($row['applied_at']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No applications received yet.</p>
    <?php endif; ?>

    <?php $conn->close(); ?>
</div>

</body>
</html>
