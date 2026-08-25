<?php
$servername = "localhost";
$username   = "root";
$password   = "12345678";
$dbname     = "my-website";

// Connection መፍጠር
$conn = new mysqli($servername, $username, $password, $dbname);

// Connection ማረጋገጥ
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title        = htmlspecialchars($_POST['title']);
    $company_name = htmlspecialchars($_POST['company_name']);
    $category_id  = $_POST['category_id'];
    $location     = htmlspecialchars($_POST['location']);
    $job_type     = $_POST['job_type'];
    $description  = htmlspecialchars($_POST['description']);
    $deadline     = $_POST['deadline'];

    // SQL Query
    $sql = "INSERT INTO jobs (title, company_name, category_id, location, job_type, description, deadline) 
            VALUES ('$title', '$company_name', '$category_id', '$location', '$job_type', '$description', '$deadline')";

    if ($conn->query($sql) === TRUE) {
        $message = "<div class='alert success'>Job posted successfully!</div>";
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
    <title>POST A NEW JOB</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f0f2f5; margin: 0; padding: 20px; }
        .container { max-width: 600px; background: white; margin: 20px auto; padding: 30px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #1a73e8; margin-bottom: 25px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; font-weight: bold; margin-bottom: 6px; color: #333; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 6px; box-sizing: border-box; font-size: 15px; }
        button { width: 100%; padding: 12px; background-color: #1a73e8; color: white; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; font-weight: bold; }
        button:hover { background-color: #1557b0; }
        .alert { padding: 12px; margin-bottom: 20px; border-radius: 6px; text-align: center; font-weight: bold; }
        .success { background-color: #d4edda; color: #155724; }
        .danger { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>

<div class="container">
    <h2>💼 POST A NEW JOB</h2>
    
    <?php echo $message; ?>

    <form action="" method="POST" onsubmit="return validateForm()">
        <div class="form-group">
            <label>Job Title</label>
            <input type="text" id="title" name="title" placeholder="e.g. Web Developer">
        </div>

        <div class="form-group">
            <label>Company Name</label>
            <input type="text" id="company_name" name="company_name" placeholder="e.g. Debark University / NGO">
        </div>

        <div class="form-group">
            <label>Category</label>
            <select name="category_id" id="category_id">
                <option value="1">Government (መንግስታዊ)</option>
                <option value="2">NGO (መንግስታዊ ያልሆነ)</option>
                <option value="3">Technology & IT</option>
                <option value="4">Business & Finance</option>
            </select>
        </div>

        <div class="form-group">
            <label>Location</label>
            <input type="text" id="location" name="location" placeholder="e.g. Gondar / Addis Ababa">
        </div>

        <div class="form-group">
            <label>Job Type</label>
            <select name="job_type">
                <option value="Full-Time">Full-Time</option>
                <option value="Part-Time">Part-Time</option>
                <option value="Contract">Contract</option>
            </select>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" id="description" rows="4"></textarea>
        </div>

        <div class="form-group">
            <label>Deadline</label>
            <input type="date" id="deadline" name="deadline">
        </div>

        <button type="submit">POST</button>
    </form>
</div>

<script>
function validateForm() {
    let title = document.getElementById('title').value;
    let company = document.getElementById('company_name').value;
    let deadline = document.getElementById('deadline').value;

    if (title.trim() === "" || company.trim() === "" || deadline === "") {
        alert("Please fill in all required fields!");
        return false;
    }
    return true;
}
</script>

</body>
</html>
