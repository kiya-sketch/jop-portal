<?php
$servername = "localhost";
$username   = "root";
$password   = "12345678";
$dbname     = "my-website";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$job_id = isset($_GET['job_id']) ? intval($_GET['job_id']) : 0;
$message = "";

// የስራውን መረጃ ማውጣት
$job_query = $conn->query("SELECT * FROM jobs WHERE id = $job_id");
$job = $job_query->fetch_assoc();

if (!$job) {
    die("<h3>Job vacancy not found!</h3>");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $applicant_name   = htmlspecialchars($_POST['applicant_name']);
    $email            = htmlspecialchars($_POST['email']);
    $phone            = htmlspecialchars($_POST['phone']);
    $experience_level = htmlspecialchars($_POST['experience_level']);

    $sql = "INSERT INTO applications (job_id, applicant_name, email, phone, experience_level) 
            VALUES ('$job_id', '$applicant_name', '$email', '$phone', '$experience_level')";

    if ($conn->query($sql) === TRUE) {
        $message = "<div class='alert success'>Your application has been submitted successfully!</div>";
    } else {
        $message = "<div class='alert danger'>Error: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply for <?php echo htmlspecialchars($job['title']); ?></title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; margin: 0; padding: 20px; }
        .container { max-width: 550px; background: white; margin: 30px auto; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #1a73e8; margin-bottom: 5px; }
        .job-title { text-align: center; color: #555; margin-bottom: 25px; font-weight: bold; }
        .form-group { margin-bottom: 18px; }
        label { display: block; font-weight: bold; margin-bottom: 6px; color: #333; }
        input, select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; font-size: 15px; }
        button { width: 100%; padding: 12px; background-color: #28a745; color: white; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; font-weight: bold; }
        button:hover { background-color: #218838; }
        .alert { padding: 12px; margin-bottom: 20px; border-radius: 6px; text-align: center; font-weight: bold; }
        .success { background-color: #d4edda; color: #155724; }
        .danger { background-color: #f8d7da; color: #721c24; }
        .back-link { display: block; text-align: center; margin-top: 15px; color: #1a73e8; text-decoration: none; }
    </style>
</head>
<body>

<div class="container">
    <h2>📄 Job Application Form</h2>
    <div class="job-title">Position: <?php echo htmlspecialchars($job['title']); ?> (<?php echo htmlspecialchars($job['company_name']); ?>)</div>

    <?php echo $message; ?>

    <form action="" method="POST">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="applicant_name" required placeholder="e.g. Abebe Kebede">
        </div>

        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" required placeholder="e.g. abebe@gmail.com">
        </div>

        <div class="form-group">
            <label>Phone Number</label>
            <input type="text" name="phone" required placeholder="e.g. 0911223344">
        </div>

        <div class="form-group">
            <label>Educational / Experience Level</label>
            <select name="experience_level" required>
                <option value="Fresh Graduate">Fresh Graduate</option>
                <option value="1-2 Years">1 - 2 Years Experience</option>
                <option value="3-5 Years">3 - 5 Years Experience</option>
                <option value="5+ Years">5+ Years Experience</option>
            </select>
        </div>

        <button type="submit">Submit Application</button>
    </form>

    <a href="index.php" class="back-link">⬅ Back to Job Listings</a>
    
</div>

</body>
</html>
